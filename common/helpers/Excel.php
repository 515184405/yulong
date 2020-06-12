<?php
namespace common\helpers;

use \PHPExcel;
use \PHPExcel_Reader_Excel2007;
use \PHPExcel_Reader_Excel5;
use \PHPExcel_IOFactory;

class Excel
{

    /**
     * 读取excel表格中的数据
     * @author xxx
     * @dateTime 2017-06-12T09:39:01+0800
     * @param    string $filePath excel文件路径
     * @param    integer $startRow 开始的行数
     * @return   array
     */
    public static function getExcelData($filePath, $startRow = 1, $sheetIndex = 0)
    {
        $PHPExcel = new PHPExcel();
        /**默认用excel2007读取excel，若格式不对，则用之前的版本进行读取*/
        $PHPReader = new PHPExcel_Reader_Excel2007();
        //setReadDataOnly Set read data only 只读单元格的数据，不格式化 e.g. 读时间会变成一个数据等
        $PHPReader->setReadDataOnly(TRUE);
        if (!$PHPReader->canRead($filePath)) {
            $PHPReader = new PHPExcel_Reader_Excel5();
            //setReadDataOnly Set read data only 只读单元格的数据，不格式化 e.g. 读时间会变成一个数据等
            $PHPReader->setReadDataOnly(TRUE);
            if (!$PHPReader->canRead($filePath)) {
                return 'can not read excel';
            }
        }

        $PHPExcel = $PHPReader->load($filePath);
        //获取sheet的数量
        $sheetCount = $PHPExcel->getSheetCount();
        //获取sheet的名称
        $sheetNames = $PHPExcel->getSheetNames();

        //获取所有的sheet表格数据
        $emptyRowNum = 0;
        $i = $sheetIndex;
        //超过范围
        if ($i > ($sheetCount - 1)) {
            return 'count error';
        }

        /**默认读取excel文件中的第一个工作表*/
        $currentSheet = $PHPExcel->getSheet($i);
        /**取得最大的列号*/
        $allColumn = $currentSheet->getHighestColumn();
        $allColumnIndex = \PHPExcel_Cell::columnIndexFromString($allColumn);
        /**取得一共有多少行*/
        $allRow = $currentSheet->getHighestRow();

        $arr = array();
        for ($currentRow = $startRow; $currentRow <= $allRow; $currentRow++) {
            /**从第A列开始输出*/
            $ifhasZero = false;
            for ($currentColumn = 0; $currentColumn <= $allColumnIndex; $currentColumn++) {
                $val = $currentSheet->getCellByColumnAndRow($currentColumn, $currentRow)->getValue();
                if ($val == '0') $ifhasZero = true;
                $arr[$currentRow][] = trim($val);
            }

            if ($ifhasZero == true) {
                foreach ($arr[$currentRow] as $key => $value) {
                    if ($value === '') {
                        unset($arr[$currentRow][$key]);
                    }
                }
            }

            $arr[$currentRow] = $ifhasZero ? $arr[$currentRow] : array_filter($arr[$currentRow]);
            //统计连续空行
            if (empty($arr[$currentRow]) && $emptyRowNum <= 50) {
                $emptyRowNum++;
            } else {
                $emptyRowNum = 0;
            }
            //防止坑队友的同事在excel里面弄出很多的空行，陷入很漫长的循环中，设置如果连续超过50个空行就退出循环，返回结果
            //连续50行数据为空，不再读取后面行的数据，防止读满内存
            if ($emptyRowNum > 50) {
                break;
            }
        }

        //只返回了第一个sheet的数据
        $returnData = $arr;

        //第一行数据就是空的，为了保留其原始数据，第一行数据就不做array_fiter操作；
        $returnData = $returnData && isset($returnData[$startRow]) && !empty($returnData[$startRow]) ? array_filter($returnData) : $returnData;
        return $returnData;
    }
    /**
     * 读取excel表格中的数据
     * @author xxx
     * @dateTime 2017-06-12T09:39:01+0800
     * @param    string $filePath excel文件路径
     * @param    integer $startRow 开始的行数
     * @return   array
     */
    public static function getExcelDatas($filePath, $startRow = 1, $sheetIndex = 0)
    {
        $PHPExcel = new PHPExcel();
        /**默认用excel2007读取excel，若格式不对，则用之前的版本进行读取*/
        $PHPReader = new PHPExcel_Reader_Excel2007();
        //setReadDataOnly Set read data only 只读单元格的数据，不格式化 e.g. 读时间会变成一个数据等
        $PHPReader->setReadDataOnly(TRUE);
        if (!$PHPReader->canRead($filePath)) {
            $PHPReader = new PHPExcel_Reader_Excel5();
            //setReadDataOnly Set read data only 只读单元格的数据，不格式化 e.g. 读时间会变成一个数据等
            $PHPReader->setReadDataOnly(TRUE);
            if (!$PHPReader->canRead($filePath)) {
                return 'can not read excel';
            }
        }

        $PHPExcel = $PHPReader->load($filePath);
        //获取sheet的数量
        $sheetCount = $PHPExcel->getSheetCount();
        //获取sheet的名称
        $sheetNames = $PHPExcel->getSheetNames();

        //获取所有的sheet表格数据
        $emptyRowNum = 0;
        $i = $sheetIndex;
        //超过范围
        if ($i > ($sheetCount - 1)) {
            return 'count error';
        }
        $arr = array();
        for ($i = 0; $i < $sheetCount; $i++) {
            $arr[$sheetNames[$i]] = [];
            $arr[$sheetNames[$i]] = self::getExcelData($filePath, $startRow = 1, $i);
        }
        //只返回了第一个sheet的数据
        $returnData = $arr;

        //第一行数据就是空的，为了保留其原始数据，第一行数据就不做array_fiter操作；
        return $returnData;
    }

    /**
     * 生成excel数据表
     * @param array $header 表头数据
     * @param array $body 导出数据的数组
     * @param string $file_name 生成的文件名
     * @param bool $is_download 是否直接下载
     * @param string $path 生成文件保存路径,$is_download为false时生效
     * @return bool
     * @throws \PHPExcel_Exception
     * @throws \PHPExcel_Reader_Exception
     * @throws \PHPExcel_Writer_Exception
     */
    public static function createExcelFromData($header, $body = array(), $file_name = 'data', $is_download = true, $path = '')
    {
        if (!count($header) || !count($body)) {
            return false;
        }
        $body = array_values($body);
        $objPHPExcel = new PHPExcel();

        // Set document properties
        $objPHPExcel->getProperties()->setCreator("Maarten Balliauw")
            ->setLastModifiedBy("Maarten Balliauw")
            ->setTitle("Office 2007 XLSX Test Document")
            ->setSubject("Office 2007 XLSX Test Document")
            ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");

        if (!empty($header)) {
            $num_one = 0;
            foreach ($header as $k => $v) {
                $letter_one = self::stringFromColumnIndex($num_one);
                $objSheet = $objPHPExcel->getActiveSheet();
                $objSheet->setCellValue($letter_one . '1', $v);
//                $objSheet->getStyle($letter_one . '1')->getFill()->setFillType(\PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setARGB('75FF68'); //设置标题背景颜色
                $objSheet->getColumnDimension($letter_one)->setAutoSize(true);
                $num_one++;
                $objPHPExcel->getActiveSheet()->getStyle($letter_one.'1')->getFont()->setBold(true);
            }
        }

        //die;
        if (!empty($body)) {
            $a = 0;
            foreach ($body as $key => $val) {
                $count = $key + 2;
                $num = 0;
                foreach ($header as $k => $v) {
                    $letter_two = self::stringFromColumnIndex($num);
                    $objSheet = $objPHPExcel->getActiveSheet();
                    //$objSheet->getColumnDimension($letter_two)->setAutoSize(true);//设置宽度自适应
                    $value = isset($val[$k]) ? $val[$k] : '';
                    $objSheet->setCellValueExplicit($letter_two . $count, $value, \PHPExcel_Cell_DataType::TYPE_STRING);
                    $num++;
                }
                /*$a++;
                // 更新缓存的进度
                $cache = \Yii::$app->cache;
                if($cache->exists('process_num'))
                    $cache->delete('process_num');
                $cache->madd([
                    'process_num' => $a,
                ]);*/
            }
        }
        // Rename worksheet
        $objPHPExcel->getActiveSheet()->setTitle('工作表');

        // Set active sheet index to the first sheet, so Excel opens this as the first sheet
        $objPHPExcel->setActiveSheetIndex(0);
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

        if ($is_download || empty($path)) {
            // Redirect output to a client’s web browser (Excel2007)
            header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
            header('Content-Disposition: attachment;filename="' . $file_name . '.xlsx"');
            header('Cache-Control: max-age=0');
            // If you're serving to IE 9, then the following may be needed
            header('Cache-Control: max-age=1');

            // If you're serving to IE over SSL, then the following may be needed
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
            header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
            header('Pragma: public'); // HTTP/1.0
            $objWriter->save('php://output');
            exit;
        } else {
            $objWriter->save($path);
        }
        unset($body);
    }

    public static function stringFromColumnIndex($pColumnIndex = 0)
    {
        //    Using a lookup cache adds a slight memory overhead, but boosts speed
        //    caching using a static within the method is faster than a class static,
        //        though it's additional memory overhead
        static $_indexCache = array();

        if (!isset($_indexCache[$pColumnIndex])) {
            // Determine column string
            if ($pColumnIndex < 26) {
                $_indexCache[$pColumnIndex] = chr(65 + $pColumnIndex);
            } elseif ($pColumnIndex < 702) {
                $_indexCache[$pColumnIndex] = chr(64 + ($pColumnIndex / 26)) .
                    chr(65 + $pColumnIndex % 26);
            } else {
                $_indexCache[$pColumnIndex] = chr(64 + (($pColumnIndex - 26) / 676)) .
                    chr(65 + ((($pColumnIndex - 26) % 676) / 26)) .
                    chr(65 + $pColumnIndex % 26);
            }
        }
        return $_indexCache[$pColumnIndex];
    }
    
}
