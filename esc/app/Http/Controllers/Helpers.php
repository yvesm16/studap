<?php
namespace App\Http\Controllers;

use Illuminate\Support\Facades\Input;

class Helpers extends Controller {
    public static function setDatatable($cQryObj, $aColumns = array(), $sIndexColumn = "")
    {
        $iDisplayStart   = Input::get('iDisplayStart');
        $iDisplayLength = Input::get('iDisplayLength');
        $iSortCol   = Input::get('iSortCol_0');
        $iSortingCols = Input::get('iSortingCols');
        $sSearch    = Input::get('sSearch');

        /* LIMIT */
        $sLimit = "";
        if (isset($iDisplayStart) && $iDisplayLength != '-1') {
            $sLimit = $iDisplayStart.", ".$iDisplayLength;
        }

        /* SORT */
        $sOrder = "";
        if (isset($iSortCol)) {
            for ($i=0; $i < intval($iSortingCols); $i++) {
                if (Input::get('bSortable_'.intval(Input::get('iSortCol_'.$i))) == "true") {
                    $sOrder .= $aColumns[intval(Input::get('iSortCol_'.$i))]."*".Input::get('sSortDir_'.$i).',';
                }
            }
        }

        /* WHERE */
        $sWhere = "";
        if ($sSearch != "") {
            for ($i=0; $i < count($aColumns); $i++) {
                if(isset($aColumns[$i]) && !empty($aColumns[$i])) {
                    $sWhere .= $aColumns[$i]."*".$sSearch."|";
                }
            }
        }

        for ($i=0; $i < count($aColumns); $i++) {
            if(isset($aColumns[$i]) && !empty($aColumns[$i])) {
                if (Input::get('bSearchable_'.$i) == "true" && Input::get('sSearch_'.$i) != '') {
                    if ($sWhere == "") {
                        $sWhere = "WHERE ";
                    } else {
                        $sWhere = "AND ";
                    }
                    $sWhere .= $aColumns[$i].", ".Input::get('sSearch_'.$i);
                }
            }
        }

        $order_by	= explode(",", $sOrder);
        $limits		= explode(",", $sLimit);
        $filter		= explode("|", $sWhere);

        $cQryObjOrig = clone $cQryObj;
        $cQryObjTemp = clone $cQryObj;
        $cQryObjTemp = $cQryObjTemp->take($limits[1])->skip($limits[0]);

        /*if ($sWhere != "") {
            for ($i=0; $i < count($filter) -1; $i++) {
                $xFilter = explode("*", $filter[$i]);
                if($i == 0) {
                    $cQryObjTemp = $cQryObjTemp->where($xFilter[0], 'LIKE', '%'.$xFilter[1].'%');
                    $cQryObjOrig = $cQryObjOrig->where($xFilter[0], 'LIKE', '%'.$xFilter[1].'%');
                } else {
                    $cQryObjTemp = $cQryObjTemp->where($xFilter[0], 'LIKE', '%'.$xFilter[1].'%', 'OR');
                    $cQryObjOrig = $cQryObjOrig->where($xFilter[0], 'LIKE', '%'.$xFilter[1].'%', 'OR');
                }
            }
        }*/

        if ($sWhere != "") {
            $cQryObjTemp->where(function($query) use ($i, $filter, $cQryObjTemp, $cQryObjOrig) {
                for ($i=0; $i < count($filter) -1; $i++) {
                    $xFilter = explode("*", $filter[$i]);
                    if($i == 0) {
                        $cQryObjTemp = $query->where($xFilter[0], 'LIKE', '%'.$xFilter[1].'%');
                        $cQryObjOrig = $query->where($xFilter[0], 'LIKE', '%'.$xFilter[1].'%');
                    } else {
                        $cQryObjTemp = $query->where($xFilter[0], 'LIKE', '%'.$xFilter[1].'%', 'OR');
                        $cQryObjOrig = $query->where($xFilter[0], 'LIKE', '%'.$xFilter[1].'%', 'OR');
                    }
                }
            });
        }

        if ($sOrder != "") {
            for ($i=0; $i < count($order_by) -1; $i++) {
                $xOrder = explode("*", $order_by[$i]);
                if($xOrder[0]) {
                    $cQryObjTemp = $cQryObjTemp->orderBy($xOrder[0], $xOrder[1]);
                    $cQryObjOrig = $cQryObjOrig->orderBy($xOrder[0], $xOrder[1]);
                }
            }
        }

        /* OUTPUT DATA */
        $cQryObjResult 	= $cQryObjTemp->get();

        $output = array(
            "sEcho"					=> intval(Input::get('sEcho')),
            "iTotalRecords" 		=> count($cQryObjOrig->get()),
            "iTotalDisplayRecords" 	=> count($cQryObjOrig->get()),
            "aaData" 				=> array(),
            'objResult'             => $cQryObjResult,
        );

        return $output;
    }

    public static function sendEmail($email_to,$email_subject,$email_data,$email_template = 'email_template')
    {
        $email = Mail::queue('emails.'.$email_template,$email_data,function($message) use($email_data,$email_to,$email_subject)
        {
            $message->to($email_to)->subject($email_subject);

        });
        return $email;
    }

    public static function json_output($type, $data) {
        $array = array(
            'type' => $type,
            'data' => $data
        );

        return json_encode($array);
    }
}
