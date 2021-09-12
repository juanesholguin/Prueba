<?php

namespace Drupal\my_users\Controller;

use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\HttpFoundation\Response;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Drupal\Core\Url;
use Drupal\Core\Link;

/**
 * Returns responses for My users routes.
 */
class MyUsersController extends ControllerBase
{

  /**
   * Consult register users
   * @return array
   */
  public function consult() {
    global $base_url;
    $query = \Drupal::database()->select('myusers', 'u');
    $query->fields('u');
    $pager = $query->extend('Drupal\Core\Database\Query\PagerSelectExtender')->limit(10);
    $result = $pager->execute()->fetchAll();

    $rows = [];

    foreach ($result as $item) {
      $row = (array)$item;
      $rows[] = $row;
    }

    $build['table'] = [
      '#rows' => $rows,
      '#header' => ['Id', 'Name'],
      '#type' => 'table'
    ];
    $build['pager'] = array(
      '#type' => 'pager'
    );

    $url = Url::fromUri($base_url.'/users/export');
    $link = Link::fromTextAndUrl('Dowload', $url);

    $link = $link->toRenderable();
    $build['Download'] = $link;
    return $build;
  }

  /**
   * Export register users
   * @return array
   */
  public function export() {

    $query = \Drupal::database()->select('myusers', 'u');
    $query->fields('u');
    $result = $query->execute()->fetchAll();

    $response = new Response();
    $response->headers->set('Pragma', 'no-cache');
    $response->headers->set('Expires', '0');
    $response->headers->set('Content-Type', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    $response->headers->set('Content-Disposition', 'attachment; filename=spreadsheet.xlsx');

    $spreadsheet = new Spreadsheet();

    $key = 2;
    for ($i = 1; $i <= count($result); $i++) {
      $spreadsheet->setActiveSheetIndex(0)
        ->setCellValue('A1' , 'Id')
        ->setCellValue('B1' , 'Nombres')
        ->setCellValue('A' . $key, '' . $result[$i - 1]->id . '')
        ->setCellValue('B' . $key, '' . $result[$i - 1]->nombre . '');
      $key++;
    }

    $spreadsheet->getActiveSheet()->setTitle('My users');

    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    ob_start();
    $writer->save('php://output');
    $content = ob_get_clean();
    $response->setContent($content);

    return $response;

  }

  /**
   * Import register users
   * @return array
   */
  public function import() {
    $build['content'] = [
      '#type' => 'item',
      '#markup' => $this->t('Import'),
    ];

    return $build;
  }

  public function download() {
    dump("entra");
    $form_state['redirect'] = url('/users/export');
  }
}
