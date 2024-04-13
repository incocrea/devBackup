<?php
class grid_tb_courses_lookup
{
//  
   function lookup_is_displayed(&$is_displayed) 
   {
      $conteudo = "" ; 
      if ($is_displayed == "1")
      { 
          $conteudo = " " . $this->Ini->Nm_lang['lang_active'] . "";
      } 
      if ($is_displayed == "0")
      { 
          $conteudo = "{ lang_inactive}";
      } 
      if (!empty($conteudo)) 
      { 
          $is_displayed = $conteudo; 
      } 
   }  
}
?>
