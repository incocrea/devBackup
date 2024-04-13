<?php
class certificado_grid
{
   var $Ini;
   var $Erro;
   var $Pdf;
   var $Db;
   var $rs_grid;
   var $nm_grid_sem_reg;
   var $SC_seq_register;
   var $nm_location;
   var $nm_data;
   var $nm_cod_barra;
   var $sc_proc_grid; 
   var $nmgp_botoes = array();
   var $Campos_Mens_erro;
   var $NM_raiz_img; 
   var $Font_ttf; 
   var $v_cliente_nombre = array();
   var $v_fecha_terminacion = array();
   var $c_enlace_imagen = array();
   var $c_informacion = array();
   var $con_url = array();
//--- 
 function monta_grid($linhas = 0)
 {

   clearstatcache();
   $this->inicializa();
   $this->grid();
 }
//--- 
 function inicializa()
 {
   global $nm_saida, 
   $rec, $nmgp_chave, $nmgp_opcao, $nmgp_ordem, $nmgp_chave_det, 
   $nmgp_quant_linhas, $nmgp_quant_colunas, $nmgp_url_saida, $nmgp_parms;
//
   $this->nm_data = new nm_data("es");
   include_once("../_lib/lib/php/nm_font_tcpdf.php");
   $this->default_font = '';
   $this->default_font_sr  = '';
   $this->default_style    = '';
   $this->default_style_sr = 'B';
   $Tp_papel = "LETTER";
   $old_dir = getcwd();
   $File_font_ttf     = "";
   $temp_font_ttf     = "";
   $this->Font_ttf    = false;
   $this->Font_ttf_sr = false;
   if (empty($this->default_font) && isset($arr_font_tcpdf[$this->Ini->str_lang]))
   {
       $this->default_font = $arr_font_tcpdf[$this->Ini->str_lang];
   }
   elseif (empty($this->default_font))
   {
       $this->default_font = "Times";
   }
   if (empty($this->default_font_sr) && isset($arr_font_tcpdf[$this->Ini->str_lang]))
   {
       $this->default_font_sr = $arr_font_tcpdf[$this->Ini->str_lang];
   }
   elseif (empty($this->default_font_sr))
   {
       $this->default_font_sr = "Times";
   }
   $_SESSION['scriptcase']['certificado']['default_font'] = $this->default_font;
   chdir($this->Ini->path_third . "/tcpdf/");
   include_once("tcpdf.php");
   chdir($old_dir);
   $this->Pdf = new TCPDF('L', 'mm', $Tp_papel, true, 'UTF-8', false);
   $this->Pdf->setPrintHeader(false);
   $this->Pdf->setPrintFooter(false);
   if (!empty($File_font_ttf))
   {
       $this->Pdf->addTTFfont($File_font_ttf, "", "", 32, $_SESSION['scriptcase']['dir_temp'] . "/");
   }
   $this->Pdf->SetDisplayMode('real');
   $this->aba_iframe = false;
   if (isset($_SESSION['scriptcase']['sc_aba_iframe']))
   {
       foreach ($_SESSION['scriptcase']['sc_aba_iframe'] as $aba => $apls_aba)
       {
           if (in_array("certificado", $apls_aba))
           {
               $this->aba_iframe = true;
               break;
           }
       }
   }
   if ($_SESSION['sc_session'][$this->Ini->sc_page]['certificado']['iframe_menu'] && (!isset($_SESSION['scriptcase']['menu_mobile']) || empty($_SESSION['scriptcase']['menu_mobile'])))
   {
       $this->aba_iframe = true;
   }
   $this->nmgp_botoes['exit'] = "on";
   $this->sc_proc_grid = false; 
   $this->NM_raiz_img = $this->Ini->root;
   $_SESSION['scriptcase']['sc_sql_ult_conexao'] = ''; 
   $this->nm_where_dinamico = "";
   $this->nm_grid_colunas = 0;
   if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['certificado']['campos_busca']) && !empty($_SESSION['sc_session'][$this->Ini->sc_page]['certificado']['campos_busca']))
   { 
       $Busca_temp = $_SESSION['sc_session'][$this->Ini->sc_page]['certificado']['campos_busca'];
       if ($_SESSION['scriptcase']['charset'] != "UTF-8")
       {
           $Busca_temp = NM_conv_charset($Busca_temp, $_SESSION['scriptcase']['charset'], "UTF-8");
       }
       $this->v_cliente_nombre[0] = (isset($Busca_temp['v_cliente_nombre'])) ? $Busca_temp['v_cliente_nombre'] : ""; 
       $tmp_pos = (is_string($this->v_cliente_nombre[0])) ? strpos($this->v_cliente_nombre[0], "##@@") : false;
       if ($tmp_pos !== false && !is_array($this->v_cliente_nombre[0]))
       {
           $this->v_cliente_nombre[0] = substr($this->v_cliente_nombre[0], 0, $tmp_pos);
       }
       $this->v_fecha_terminacion[0] = (isset($Busca_temp['v_fecha_terminacion'])) ? $Busca_temp['v_fecha_terminacion'] : ""; 
       $tmp_pos = (is_string($this->v_fecha_terminacion[0])) ? strpos($this->v_fecha_terminacion[0], "##@@") : false;
       if ($tmp_pos !== false && !is_array($this->v_fecha_terminacion[0]))
       {
           $this->v_fecha_terminacion[0] = substr($this->v_fecha_terminacion[0], 0, $tmp_pos);
       }
       $v_fecha_terminacion_2 = (isset($Busca_temp['v_fecha_terminacion_input_2'])) ? $Busca_temp['v_fecha_terminacion_input_2'] : ""; 
       $this->v_fecha_terminacion_2 = $v_fecha_terminacion_2; 
       $this->c_enlace_imagen[0] = (isset($Busca_temp['c_enlace_imagen'])) ? $Busca_temp['c_enlace_imagen'] : ""; 
       $tmp_pos = (is_string($this->c_enlace_imagen[0])) ? strpos($this->c_enlace_imagen[0], "##@@") : false;
       if ($tmp_pos !== false && !is_array($this->c_enlace_imagen[0]))
       {
           $this->c_enlace_imagen[0] = substr($this->c_enlace_imagen[0], 0, $tmp_pos);
       }
       $this->c_informacion[0] = (isset($Busca_temp['c_informacion'])) ? $Busca_temp['c_informacion'] : ""; 
       $tmp_pos = (is_string($this->c_informacion[0])) ? strpos($this->c_informacion[0], "##@@") : false;
       if ($tmp_pos !== false && !is_array($this->c_informacion[0]))
       {
           $this->c_informacion[0] = substr($this->c_informacion[0], 0, $tmp_pos);
       }
       $this->con_url[0] = (isset($Busca_temp['con_url'])) ? $Busca_temp['con_url'] : ""; 
       $tmp_pos = (is_string($this->con_url[0])) ? strpos($this->con_url[0], "##@@") : false;
       if ($tmp_pos !== false && !is_array($this->con_url[0]))
       {
           $this->con_url[0] = substr($this->con_url[0], 0, $tmp_pos);
       }
   } 
   else 
   { 
       $this->v_fecha_terminacion_2 = ""; 
   } 
   $this->nm_field_dinamico = array();
   $this->nm_order_dinamico = array();
   $this->sc_where_orig   = $_SESSION['sc_session'][$this->Ini->sc_page]['certificado']['where_orig'];
   $this->sc_where_atual  = $_SESSION['sc_session'][$this->Ini->sc_page]['certificado']['where_pesq'];
   $this->sc_where_filtro = $_SESSION['sc_session'][$this->Ini->sc_page]['certificado']['where_pesq_filtro'];
   $_SESSION['scriptcase']['certificado']['contr_erro'] = 'on';
 

$_SESSION['scriptcase']['certificado']['contr_erro'] = 'off'; 
   $dir_raiz          = strrpos($_SERVER['PHP_SELF'],"/") ;  
   $dir_raiz          = substr($_SERVER['PHP_SELF'], 0, $dir_raiz + 1) ;  
   $this->nm_location = $this->Ini->sc_protocolo . $this->Ini->server . $dir_raiz; 
   $_SESSION['scriptcase']['contr_link_emb'] = $this->nm_location;
   $_SESSION['sc_session'][$this->Ini->sc_page]['certificado']['qt_col_grid'] = 1 ;  
   if (isset($_SESSION['scriptcase']['sc_apl_conf']['certificado']['cols']) && !empty($_SESSION['scriptcase']['sc_apl_conf']['certificado']['cols']))
   {
       $_SESSION['sc_session'][$this->Ini->sc_page]['certificado']['qt_col_grid'] = $_SESSION['scriptcase']['sc_apl_conf']['certificado']['cols'];  
       unset($_SESSION['scriptcase']['sc_apl_conf']['certificado']['cols']);
   }
   if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['certificado']['ordem_select']))  
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['certificado']['ordem_select'] = array(); 
   } 
   if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['certificado']['ordem_quebra']))  
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['certificado']['ordem_grid'] = "" ; 
       $_SESSION['sc_session'][$this->Ini->sc_page]['certificado']['ordem_ant']  = ""; 
       $_SESSION['sc_session'][$this->Ini->sc_page]['certificado']['ordem_desc'] = "" ; 
   }   
   if (!empty($nmgp_parms) && $_SESSION['sc_session'][$this->Ini->sc_page]['certificado']['opcao'] != "pdf")   
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['certificado']['opcao'] = "igual";
       $rec = "ini";
   }
   if (!isset($_SESSION['sc_session'][$this->Ini->sc_page]['certificado']['where_orig']) || $_SESSION['sc_session'][$this->Ini->sc_page]['certificado']['prim_cons'] || !empty($nmgp_parms))  
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['certificado']['prim_cons'] = false;  
       $_SESSION['sc_session'][$this->Ini->sc_page]['certificado']['where_orig'] = " where (v.Cliente_id =" . $_SESSION['par_cliente_id'] . " AND v.course_id = " . $_SESSION['par_clicurso'] . ")";  
       $_SESSION['sc_session'][$this->Ini->sc_page]['certificado']['where_pesq']        = $_SESSION['sc_session'][$this->Ini->sc_page]['certificado']['where_orig'];  
       $_SESSION['sc_session'][$this->Ini->sc_page]['certificado']['where_pesq_ant']    = $_SESSION['sc_session'][$this->Ini->sc_page]['certificado']['where_orig'];  
       $_SESSION['sc_session'][$this->Ini->sc_page]['certificado']['cond_pesq']         = ""; 
       $_SESSION['sc_session'][$this->Ini->sc_page]['certificado']['where_pesq_filtro'] = "";
   }   
   if  (!empty($this->nm_where_dinamico)) 
   {   
       $_SESSION['sc_session'][$this->Ini->sc_page]['certificado']['where_pesq'] .= $this->nm_where_dinamico;
   }   
   $this->sc_where_orig   = $_SESSION['sc_session'][$this->Ini->sc_page]['certificado']['where_orig'];
   $this->sc_where_atual  = $_SESSION['sc_session'][$this->Ini->sc_page]['certificado']['where_pesq'];
   $this->sc_where_filtro = $_SESSION['sc_session'][$this->Ini->sc_page]['certificado']['where_pesq_filtro'];
//
   if (isset($_SESSION['sc_session'][$this->Ini->sc_page]['certificado']['tot_geral'][1])) 
   { 
       $_SESSION['sc_session'][$this->Ini->sc_page]['certificado']['sc_total'] = $_SESSION['sc_session'][$this->Ini->sc_page]['certificado']['tot_geral'][1] ;  
   }
   $_SESSION['sc_session'][$this->Ini->sc_page]['certificado']['where_pesq_ant'] = $_SESSION['sc_session'][$this->Ini->sc_page]['certificado']['where_pesq'];  
//----- 
   if (in_array(strtolower($this->Ini->nm_tpbanco), $this->Ini->nm_bases_mysql))
   { 
       $nmgp_select = "SELECT v.Cliente_nombre as v_cliente_nombre, v.Fecha_terminacion as v_fecha_terminacion, c.Enlace_imagen as c_enlace_imagen, c.Informacion as c_informacion, con.url as con_url from " . $this->Ini->nm_tabela; 
   } 
   else 
   { 
       $nmgp_select = "SELECT v.Cliente_nombre as v_cliente_nombre, v.Fecha_terminacion as v_fecha_terminacion, c.Enlace_imagen as c_enlace_imagen, c.Informacion as c_informacion, con.url as con_url from " . $this->Ini->nm_tabela; 
   } 
   $nmgp_select .= " " . $_SESSION['sc_session'][$this->Ini->sc_page]['certificado']['where_pesq']; 
   $nmgp_order_by = ""; 
   $campos_order_select = "";
   foreach($_SESSION['sc_session'][$this->Ini->sc_page]['certificado']['ordem_select'] as $campo => $ordem) 
   {
        if ($campo != $_SESSION['sc_session'][$this->Ini->sc_page]['certificado']['ordem_grid']) 
        {
           if (!empty($campos_order_select)) 
           {
               $campos_order_select .= ", ";
           }
           $campos_order_select .= $campo . " " . $ordem;
        }
   }
   if (!empty($_SESSION['sc_session'][$this->Ini->sc_page]['certificado']['ordem_grid'])) 
   { 
       $nmgp_order_by = " order by " . $_SESSION['sc_session'][$this->Ini->sc_page]['certificado']['ordem_grid'] . $_SESSION['sc_session'][$this->Ini->sc_page]['certificado']['ordem_desc']; 
   } 
   if (!empty($campos_order_select)) 
   { 
       if (!empty($nmgp_order_by)) 
       { 
          $nmgp_order_by .= ", " . $campos_order_select; 
       } 
       else 
       { 
          $nmgp_order_by = " order by $campos_order_select"; 
       } 
   } 
   $nmgp_select .= $nmgp_order_by; 
   $_SESSION['sc_session'][$this->Ini->sc_page]['certificado']['order_grid'] = $nmgp_order_by;
   $_SESSION['scriptcase']['sc_sql_ult_comando'] = $nmgp_select; 
   $this->rs_grid = $this->Db->Execute($nmgp_select) ; 
   if ($this->rs_grid === false && !$this->rs_grid->EOF && $GLOBALS["NM_ERRO_IBASE"] != 1) 
   { 
       $this->Erro->mensagem(__FILE__, __LINE__, "banco", $this->Ini->Nm_lang['lang_errm_dber'], $this->Db->ErrorMsg()); 
       exit ; 
   }  
   if ($this->rs_grid->EOF || ($this->rs_grid === false && $GLOBALS["NM_ERRO_IBASE"] == 1)) 
   { 
       $this->nm_grid_sem_reg = $this->SC_conv_utf8($this->Ini->Nm_lang['lang_errm_empt']); 
   }  
// 
 }  
// 
 function Pdf_init()
 {
     if ($_SESSION['scriptcase']['reg_conf']['css_dir'] == "RTL")
     {
         $this->Pdf->setRTL(true);
     }
     $this->Pdf->setHeaderMargin(0);
     $this->Pdf->setFooterMargin(0);
     $this->Pdf->setCellMargins($left = 0, $top = 0, $right = 0, $bottom = -10);
     $this->Pdf->SetAutoPageBreak(true, -10);
     if ($this->Font_ttf)
     {
         $this->Pdf->SetFont($this->default_font, $this->default_style, 14, $this->def_TTF);
     }
     else
     {
         $this->Pdf->SetFont($this->default_font, $this->default_style, 14);
     }
     $this->Pdf->SetTextColor(0, 0, 0);
 }
// 
//----- 
 function grid($linhas = 0)
 {
    global 
           $nm_saida, $nm_url_saida;
   $_SESSION['sc_session'][$this->Ini->sc_page]['certificado']['labels']['v_cliente_nombre'] = "{lang_vw_clientesxcursos_fld_Cliente_nombre}";
   $_SESSION['sc_session'][$this->Ini->sc_page]['certificado']['labels']['v_fecha_terminacion'] = "Fecha Terminacion";
   $_SESSION['sc_session'][$this->Ini->sc_page]['certificado']['labels']['c_enlace_imagen'] = "{lang_tb_certificados_fld_Enlace_imagen}";
   $_SESSION['sc_session'][$this->Ini->sc_page]['certificado']['labels']['c_informacion'] = "{lang_tb_certificados_fld_Informacion}";
   $_SESSION['sc_session'][$this->Ini->sc_page]['certificado']['labels']['con_url'] = "{lang_tb_confirmaciones_fld_url}";
   $HTTP_REFERER = (isset($_SERVER['HTTP_REFERER'])) ? $_SERVER['HTTP_REFERER'] : ""; 
   $_SESSION['sc_session'][$this->Ini->sc_page]['certificado']['seq_dir'] = 0; 
   $_SESSION['sc_session'][$this->Ini->sc_page]['certificado']['sub_dir'] = array(); 
   $this->sc_where_orig   = $_SESSION['sc_session'][$this->Ini->sc_page]['certificado']['where_orig'];
   $this->sc_where_atual  = $_SESSION['sc_session'][$this->Ini->sc_page]['certificado']['where_pesq'];
   $this->sc_where_filtro = $_SESSION['sc_session'][$this->Ini->sc_page]['certificado']['where_pesq_filtro'];
   if (isset($_SESSION['scriptcase']['sc_apl_conf']['certificado']['lig_edit']) && $_SESSION['scriptcase']['sc_apl_conf']['certificado']['lig_edit'] != '')
   {
       $_SESSION['sc_session'][$this->Ini->sc_page]['certificado']['mostra_edit'] = $_SESSION['scriptcase']['sc_apl_conf']['certificado']['lig_edit'];
   }
   if (!empty($this->nm_grid_sem_reg))
   {
       $this->Pdf_init();
       $this->Pdf->AddPage();
       if ($this->Font_ttf_sr)
       {
           $this->Pdf->SetFont($this->default_font_sr, 'B', 12, $this->def_TTF);
       }
       else
       {
           $this->Pdf->SetFont($this->default_font_sr, 'B', 12);
       }
       $this->Pdf->Text(0.000000, 0.000000, html_entity_decode($this->nm_grid_sem_reg, ENT_COMPAT, $_SESSION['scriptcase']['charset']));
       $this->Pdf->Output($this->Ini->root . $this->Ini->nm_path_pdf, 'F');
       return;
   }
// 
   $Init_Pdf = true;
   $this->SC_seq_register = 0; 
   while (!$this->rs_grid->EOF) 
   {  
      $this->nm_grid_colunas = 0; 
      $nm_quant_linhas = 0;
      $this->Pdf->setImageScale(1.33);
      $this->Pdf->AddPage();
      $this->Pdf_init();
      while (!$this->rs_grid->EOF && $nm_quant_linhas < $_SESSION['sc_session'][$this->Ini->sc_page]['certificado']['qt_col_grid']) 
      {  
          $this->sc_proc_grid = true;
          $this->SC_seq_register++; 
          $this->v_cliente_nombre[$this->nm_grid_colunas] = $this->rs_grid->fields[0] ;  
          $this->v_fecha_terminacion[$this->nm_grid_colunas] = $this->rs_grid->fields[1] ;  
          $this->c_enlace_imagen[$this->nm_grid_colunas] = $this->rs_grid->fields[2] ;  
          $this->c_informacion[$this->nm_grid_colunas] = $this->rs_grid->fields[3] ;  
          $this->con_url[$this->nm_grid_colunas] = $this->rs_grid->fields[4] ;  
          $this->v_cliente_nombre[$this->nm_grid_colunas] = sc_strip_script($this->v_cliente_nombre[$this->nm_grid_colunas]);
          if ($this->v_cliente_nombre[$this->nm_grid_colunas] === "") 
          { 
              $this->v_cliente_nombre[$this->nm_grid_colunas] = "" ;  
          } 
          if ($this->v_cliente_nombre[$this->nm_grid_colunas] !== "") 
          { 
              $this->v_cliente_nombre[$this->nm_grid_colunas] = sc_strtoupper($this->v_cliente_nombre[$this->nm_grid_colunas]); 
          } 
          $this->v_cliente_nombre[$this->nm_grid_colunas] = $this->SC_conv_utf8($this->v_cliente_nombre[$this->nm_grid_colunas]);
          $this->v_fecha_terminacion[$this->nm_grid_colunas] = sc_strip_script($this->v_fecha_terminacion[$this->nm_grid_colunas]);
          if ($this->v_fecha_terminacion[$this->nm_grid_colunas] === "") 
          { 
              $this->v_fecha_terminacion[$this->nm_grid_colunas] = "" ;  
          } 
          else    
          { 
               $v_fecha_terminacion_x =  $this->v_fecha_terminacion[$this->nm_grid_colunas];
               nm_conv_limpa_dado($v_fecha_terminacion_x, "YYYY-MM-DD");
               if (is_numeric($v_fecha_terminacion_x) && strlen($v_fecha_terminacion_x) > 0) 
               { 
                   $this->nm_data->SetaData($this->v_fecha_terminacion[$this->nm_grid_colunas], "YYYY-MM-DD");
                   $this->v_fecha_terminacion[$this->nm_grid_colunas] = html_entity_decode($this->nm_data->FormataSaida($this->nm_data->FormatRegion("DT", "ddmmaaaa")), ENT_COMPAT, $_SESSION['scriptcase']['charset']);
               } 
          } 
          $this->v_fecha_terminacion[$this->nm_grid_colunas] = $this->SC_conv_utf8($this->v_fecha_terminacion[$this->nm_grid_colunas]);
          $this->c_enlace_imagen[$this->nm_grid_colunas] = sc_strip_script($this->c_enlace_imagen[$this->nm_grid_colunas]);
          if ($this->c_enlace_imagen[$this->nm_grid_colunas] === "") 
          { 
              $this->c_enlace_imagen[$this->nm_grid_colunas] = "" ;  
          } 
          $this->c_enlace_imagen[$this->nm_grid_colunas] = $this->SC_conv_utf8($this->c_enlace_imagen[$this->nm_grid_colunas]);
          $this->c_informacion[$this->nm_grid_colunas] = sc_strip_script($this->c_informacion[$this->nm_grid_colunas]);
          if ($this->c_informacion[$this->nm_grid_colunas] === "") 
          { 
              $this->c_informacion[$this->nm_grid_colunas] = "" ;  
          } 
          $this->c_informacion[$this->nm_grid_colunas] = $this->SC_conv_utf8($this->c_informacion[$this->nm_grid_colunas]);
          $this->con_url[$this->nm_grid_colunas] = (string)$this->con_url[$this->nm_grid_colunas]; 
          if (empty($this->con_url[$this->nm_grid_colunas]) || $this->con_url[$this->nm_grid_colunas] == "none" || $this->con_url[$this->nm_grid_colunas] == "*nm*") 
          { 
              $this->con_url[$this->nm_grid_colunas] = "" ;  
              $out_con_url = "" ; 
          } 
          elseif ($this->Ini->Gd_missing)
          { 
              $this->con_url[$this->nm_grid_colunas] = "<span class=\"scErrorLine\">" . $this->Ini->Nm_lang['lang_errm_gd'] . "</span>";
              $out_con_url = "" ; 
          } 
          else   
          { 
              $out_con_url = $this->Ini->path_imag_temp . "/sc_con_url_" . $_SESSION['scriptcase']['sc_num_img'] . session_id() . ".png";   
              QRcode::png($this->con_url[$this->nm_grid_colunas], $this->Ini->root . $out_con_url, 1,3,1);
              $_SESSION['scriptcase']['sc_num_img']++;
          } 
              $this->con_url[$this->nm_grid_colunas] = $this->NM_raiz_img . $out_con_url;
          $this->con_url[$this->nm_grid_colunas] = $this->SC_conv_utf8($this->con_url[$this->nm_grid_colunas]);
            $cell_v_Cliente_nombre = array('posx' => '33.118424999995824', 'posy' => '85.44401249998923', 'data' => $this->v_cliente_nombre[$this->nm_grid_colunas], 'width'      => '0', 'align'      => 'C', 'font_type'  => 'Times', 'font_size'  => '30', 'color_r'    => '58', 'color_g'    => '170', 'color_b'    => '53', 'font_style' => 'BI');
            $cell_c_Informacion = array('posx' => '65.29837291665844', 'posy' => '100.85175833332063', 'data' => $this->c_informacion[$this->nm_grid_colunas], 'width'      => '170', 'align'      => 'C', 'font_type'  => $this->default_font, 'font_size'  => '15', 'color_r'    => '0', 'color_g'    => '0', 'color_b'    => '0', 'font_style' => $this->default_style);
            $cell_con_url = array('posx' => '19.260872916664237', 'posy' => '169.85429791664527', 'data' => $this->con_url[$this->nm_grid_colunas], 'width'      => '0', 'align'      => 'L', 'font_type'  => $this->default_font, 'font_size'  => '14', 'color_r'    => '0', 'color_g'    => '0', 'color_b'    => '0', 'font_style' => $this->default_style);
/*------------------ Layout -----------------*/
$enlace = $this->c_enlace_imagen[$this->nm_grid_colunas];
$this->Pdf->Image($enlace,0,0,362,279,'');


            $this->Pdf->SetFont($cell_v_Cliente_nombre['font_type'], $cell_v_Cliente_nombre['font_style'], $cell_v_Cliente_nombre['font_size']);
            $this->pdf_text_color($cell_v_Cliente_nombre['data'], $cell_v_Cliente_nombre['color_r'], $cell_v_Cliente_nombre['color_g'], $cell_v_Cliente_nombre['color_b']);
            if (!empty($cell_v_Cliente_nombre['posx']) && !empty($cell_v_Cliente_nombre['posy']))
            {
                $this->Pdf->SetXY($cell_v_Cliente_nombre['posx'], $cell_v_Cliente_nombre['posy']);
            }
            elseif (!empty($cell_v_Cliente_nombre['posx']))
            {
                $this->Pdf->SetX($cell_v_Cliente_nombre['posx']);
            }
            elseif (!empty($cell_v_Cliente_nombre['posy']))
            {
                $this->Pdf->SetY($cell_v_Cliente_nombre['posy']);
            }
            $this->Pdf->Cell($cell_v_Cliente_nombre['width'], 0, $cell_v_Cliente_nombre['data'], 0, 0, $cell_v_Cliente_nombre['align']);


            $this->Pdf->SetFont($cell_c_Informacion['font_type'], $cell_c_Informacion['font_style'], $cell_c_Informacion['font_size']);
            $this->Pdf->SetTextColor($cell_c_Informacion['color_r'], $cell_c_Informacion['color_g'], $cell_c_Informacion['color_b']);
            if (!empty($cell_c_Informacion['posx']) && !empty($cell_c_Informacion['posy']))
            {
                $this->Pdf->SetXY($cell_c_Informacion['posx'], $cell_c_Informacion['posy']);
            }
            elseif (!empty($cell_c_Informacion['posx']))
            {
                $this->Pdf->SetX($cell_c_Informacion['posx']);
            }
            elseif (!empty($cell_c_Informacion['posy']))
            {
                $this->Pdf->SetY($cell_c_Informacion['posy']);
            }
            if ($this->Font_ttf)
            {
                $this->Pdf->Cell($cell_c_Informacion['width'], 0, $cell_c_Informacion['data'], 0, 0, $cell_c_Informacion['align']);
            }
            else
            {
                $atu_X = $this->Pdf->GetX();
                $atu_Y = $this->Pdf->GetY();
                $this->Pdf->writeHTMLCell($cell_c_Informacion['width'], 0, $atu_X, $atu_Y, $cell_c_Informacion['data'], 0, 0, false, true, $cell_c_Informacion['align']);
            }

            if (isset($cell_con_url['data']) && !empty($cell_con_url['data']) && is_file($cell_con_url['data']))
            {
                $Finfo_img = finfo_open(FILEINFO_MIME_TYPE);
                $Tipo_img  = finfo_file($Finfo_img, $cell_con_url['data']);
                finfo_close($Finfo_img);
                if (substr($Tipo_img, 0, 5) == "image")
                {
                    $this->Pdf->Image($cell_con_url['data'], $cell_con_url['posx'], $cell_con_url['posy'], 0, 0);
                }
            }
          $max_Y = 0;
          $this->rs_grid->MoveNext();
          $this->sc_proc_grid = false;
          $nm_quant_linhas++ ;
      }  
   }  
   $this->rs_grid->Close();
   $this->Pdf->Output($this->Ini->root . $this->Ini->nm_path_pdf, 'F');
 }
 function pdf_text_color(&$val, $r, $g, $b)
 {
     if (is_array($val)) {
         $val = "";
     }
     $pos = strpos($val, "@SCNEG#");
     if ($pos !== false)
     {
         $cor = trim(substr($val, $pos + 7));
         $val = substr($val, 0, $pos);
         $cor = (substr($cor, 0, 1) == "#") ? substr($cor, 1) : $cor;
         if (strlen($cor) == 6)
         {
             $r = hexdec(substr($cor, 0, 2));
             $g = hexdec(substr($cor, 2, 2));
             $b = hexdec(substr($cor, 4, 2));
         }
     }
     $this->Pdf->SetTextColor($r, $g, $b);
 }
 function SC_conv_utf8($input)
 {
     if ($_SESSION['scriptcase']['charset'] != "UTF-8" && !NM_is_utf8($input))
     {
         $input = sc_convert_encoding($input, "UTF-8", $_SESSION['scriptcase']['charset']);
     }
     return $input;
 }
   function nm_conv_data_db($dt_in, $form_in, $form_out)
   {
       $dt_out = $dt_in;
       if (strtoupper($form_in) == "DB_FORMAT") {
           if ($dt_out == "null" || $dt_out == "")
           {
               $dt_out = "";
               return $dt_out;
           }
           $form_in = "AAAA-MM-DD";
       }
       if (strtoupper($form_out) == "DB_FORMAT") {
           if (empty($dt_out))
           {
               $dt_out = "null";
               return $dt_out;
           }
           $form_out = "AAAA-MM-DD";
       }
       if (strtoupper($form_out) == "SC_FORMAT_REGION") {
           $this->nm_data->SetaData($dt_in, strtoupper($form_in));
           $prep_out  = (strpos(strtolower($form_in), "dd") !== false) ? "dd" : "";
           $prep_out .= (strpos(strtolower($form_in), "mm") !== false) ? "mm" : "";
           $prep_out .= (strpos(strtolower($form_in), "aa") !== false) ? "aaaa" : "";
           $prep_out .= (strpos(strtolower($form_in), "yy") !== false) ? "aaaa" : "";
           return $this->nm_data->FormataSaida($this->nm_data->FormatRegion("DT", $prep_out));
       }
       else {
           nm_conv_form_data($dt_out, $form_in, $form_out);
           return $dt_out;
       }
   }
   function nm_gera_mask(&$nm_campo, $nm_mask)
   { 
      $trab_campo = $nm_campo;
      $trab_mask  = $nm_mask;
      $tam_campo  = strlen($nm_campo);
      $trab_saida = "";
      $str_highlight_ini = "";
      $str_highlight_fim = "";
      if(substr($nm_campo, 0, 23) == '<div class="highlight">' && substr($nm_campo, -6) == '</div>')
      {
           $str_highlight_ini = substr($nm_campo, 0, 23);
           $str_highlight_fim = substr($nm_campo, -6);

           $trab_campo = substr($nm_campo, 23, -6);
           $tam_campo  = strlen($trab_campo);
      }      $mask_num = false;
      for ($x=0; $x < strlen($trab_mask); $x++)
      {
          if (substr($trab_mask, $x, 1) == "#")
          {
              $mask_num = true;
              break;
          }
      }
      if ($mask_num )
      {
          $ver_duas = explode(";", $trab_mask);
          if (isset($ver_duas[1]) && !empty($ver_duas[1]))
          {
              $cont1 = count(explode("#", $ver_duas[0])) - 1;
              $cont2 = count(explode("#", $ver_duas[1])) - 1;
              if ($tam_campo >= $cont2)
              {
                  $trab_mask = $ver_duas[1];
              }
              else
              {
                  $trab_mask = $ver_duas[0];
              }
          }
          $tam_mask = strlen($trab_mask);
          $xdados = 0;
          for ($x=0; $x < $tam_mask; $x++)
          {
              if (substr($trab_mask, $x, 1) == "#" && $xdados < $tam_campo)
              {
                  $trab_saida .= substr($trab_campo, $xdados, 1);
                  $xdados++;
              }
              elseif ($xdados < $tam_campo)
              {
                  $trab_saida .= substr($trab_mask, $x, 1);
              }
          }
          if ($xdados < $tam_campo)
          {
              $trab_saida .= substr($trab_campo, $xdados);
          }
          $nm_campo = $str_highlight_ini . $trab_saida . $str_highlight_ini;
          return;
      }
      for ($ix = strlen($trab_mask); $ix > 0; $ix--)
      {
           $char_mask = substr($trab_mask, $ix - 1, 1);
           if ($char_mask != "x" && $char_mask != "z")
           {
               $trab_saida = $char_mask . $trab_saida;
           }
           else
           {
               if ($tam_campo != 0)
               {
                   $trab_saida = substr($trab_campo, $tam_campo - 1, 1) . $trab_saida;
                   $tam_campo--;
               }
               else
               {
                   $trab_saida = "0" . $trab_saida;
               }
           }
      }
      if ($tam_campo != 0)
      {
          $trab_saida = substr($trab_campo, 0, $tam_campo) . $trab_saida;
          $trab_mask  = str_repeat("z", $tam_campo) . $trab_mask;
      }
   
      $iz = 0; 
      for ($ix = 0; $ix < strlen($trab_mask); $ix++)
      {
           $char_mask = substr($trab_mask, $ix, 1);
           if ($char_mask != "x" && $char_mask != "z")
           {
               if ($char_mask == "." || $char_mask == ",")
               {
                   $trab_saida = substr($trab_saida, 0, $iz) . substr($trab_saida, $iz + 1);
               }
               else
               {
                   $iz++;
               }
           }
           elseif ($char_mask == "x" || substr($trab_saida, $iz, 1) != "0")
           {
               $ix = strlen($trab_mask) + 1;
           }
           else
           {
               $trab_saida = substr($trab_saida, 0, $iz) . substr($trab_saida, $iz + 1);
           }
      }
      $nm_campo = $str_highlight_ini . $trab_saida . $str_highlight_ini;
   } 
}
?>
