
function scJQGeneralAdd() {
  scLoadScInput('input:text.sc-js-input');
  scLoadScInput('input:password.sc-js-input');
  scLoadScInput('input:checkbox.sc-js-input');
  scLoadScInput('input:radio.sc-js-input');
  scLoadScInput('select.sc-js-input');
  scLoadScInput('textarea.sc-js-input');

} // scJQGeneralAdd

function scFocusField(sField) {
  var $oField = $('#id_sc_field_' + sField);

  if (0 == $oField.length) {
    $oField = $('input[name=' + sField + ']');
  }

  if (0 == $oField.length && document.F1.elements[sField]) {
    $oField = $(document.F1.elements[sField]);
  }

  if ($("#id_ac_" + sField).length > 0) {
    if ($oField.hasClass("select2-hidden-accessible")) {
      if (false == scSetFocusOnField($oField)) {
        setTimeout(function() { scSetFocusOnField($oField); }, 500);
      }
    }
    else {
      if (false == scSetFocusOnField($oField)) {
        if (false == scSetFocusOnField($("#id_ac_" + sField))) {
          setTimeout(function() { scSetFocusOnField($("#id_ac_" + sField)); }, 500);
        }
      }
      else {
        setTimeout(function() { scSetFocusOnField($oField); }, 500);
      }
    }
  }
  else {
    setTimeout(function() { scSetFocusOnField($oField); }, 500);
  }
} // scFocusField

function scSetFocusOnField($oField) {
  if ($oField.length > 0 && $oField[0].offsetHeight > 0 && $oField[0].offsetWidth > 0 && !$oField[0].disabled) {
    $oField[0].focus();
    return true;
  }
  return false;
} // scSetFocusOnField

function scEventControl_init(iSeqRow) {
  scEventControl_data["topico_" + iSeqRow] = {"blur": false, "change": false, "autocomp": false, "original": "", "calculated": ""};
  scEventControl_data["documentos_" + iSeqRow] = {"blur": false, "change": false, "autocomp": false, "original": "", "calculated": ""};
  scEventControl_data["videos_" + iSeqRow] = {"blur": false, "change": false, "autocomp": false, "original": "", "calculated": ""};
  scEventControl_data["enbed_" + iSeqRow] = {"blur": false, "change": false, "autocomp": false, "original": "", "calculated": ""};
  scEventControl_data["paginas_sugeridas_" + iSeqRow] = {"blur": false, "change": false, "autocomp": false, "original": "", "calculated": ""};
  scEventControl_data["recomendaciones_" + iSeqRow] = {"blur": false, "change": false, "autocomp": false, "original": "", "calculated": ""};
  scEventControl_data["test_" + iSeqRow] = {"blur": false, "change": false, "autocomp": false, "original": "", "calculated": ""};
  scEventControl_data["id_insumos_" + iSeqRow] = {"blur": false, "change": false, "autocomp": false, "original": "", "calculated": ""};
}

function scEventControl_active(iSeqRow) {
  if (scEventControl_data["topico_" + iSeqRow]["blur"]) {
    return true;
  }
  if (scEventControl_data["topico_" + iSeqRow]["change"]) {
    return true;
  }
  if (scEventControl_data["videos_" + iSeqRow]["blur"]) {
    return true;
  }
  if (scEventControl_data["videos_" + iSeqRow]["change"]) {
    return true;
  }
  if (scEventControl_data["enbed_" + iSeqRow]["blur"]) {
    return true;
  }
  if (scEventControl_data["enbed_" + iSeqRow]["change"]) {
    return true;
  }
  if (scEventControl_data["paginas_sugeridas_" + iSeqRow]["blur"]) {
    return true;
  }
  if (scEventControl_data["paginas_sugeridas_" + iSeqRow]["change"]) {
    return true;
  }
  if (scEventControl_data["recomendaciones_" + iSeqRow]["blur"]) {
    return true;
  }
  if (scEventControl_data["recomendaciones_" + iSeqRow]["change"]) {
    return true;
  }
  if (scEventControl_data["test_" + iSeqRow]["blur"]) {
    return true;
  }
  if (scEventControl_data["test_" + iSeqRow]["change"]) {
    return true;
  }
  if (scEventControl_data["id_insumos_" + iSeqRow]["blur"]) {
    return true;
  }
  if (scEventControl_data["id_insumos_" + iSeqRow]["change"]) {
    return true;
  }
  return false;
} // scEventControl_active

function scEventControl_active_all() {
  for (var i = 1; i < iAjaxNewLine; i++) {
    if (scEventControl_active(i)) {
      return true;
    }
  }
  return false;
} // scEventControl_active

function scEventControl_onFocus(oField, iSeq) {
  var fieldId, fieldName;
  fieldId = $(oField).attr("id");
  fieldName = fieldId.substr(12);
  scEventControl_data[fieldName]["blur"] = true;
  scEventControl_data[fieldName]["change"] = false;
} // scEventControl_onFocus

function scEventControl_onBlur(sFieldName) {
  scEventControl_data[sFieldName]["blur"] = false;
  if (scEventControl_data[sFieldName]["change"]) {
        if (scEventControl_data[sFieldName]["original"] == $("#id_sc_field_" + sFieldName).val() || scEventControl_data[sFieldName]["calculated"] == $("#id_sc_field_" + sFieldName).val()) {
          scEventControl_data[sFieldName]["change"] = false;
        }
  }
} // scEventControl_onBlur

function scEventControl_onChange(sFieldName) {
  scEventControl_data[sFieldName]["change"] = false;
} // scEventControl_onChange

function scEventControl_onAutocomp(sFieldName) {
  scEventControl_data[sFieldName]["autocomp"] = false;
} // scEventControl_onChange

var scEventControl_data = {};

function scJQEventsAdd(iSeqRow) {
  $('#id_sc_field_id_insumos_' + iSeqRow).bind('blur', function() { sc_form_tb_insumos_x_cursos_id_insumos__onblur(this, iSeqRow) })
                                         .bind('change', function() { sc_form_tb_insumos_x_cursos_id_insumos__onchange(this, iSeqRow) })
                                         .bind('focus', function() { sc_form_tb_insumos_x_cursos_id_insumos__onfocus(this, iSeqRow) });
  $('#id_sc_field_course_id_' + iSeqRow).bind('change', function() { sc_form_tb_insumos_x_cursos_course_id__onchange(this, iSeqRow) });
  $('#id_sc_field_topico_' + iSeqRow).bind('blur', function() { sc_form_tb_insumos_x_cursos_topico__onblur(this, iSeqRow) })
                                     .bind('change', function() { sc_form_tb_insumos_x_cursos_topico__onchange(this, iSeqRow) })
                                     .bind('focus', function() { sc_form_tb_insumos_x_cursos_topico__onfocus(this, iSeqRow) });
  $('#id_sc_field_documentos_' + iSeqRow).bind('blur', function() { sc_form_tb_insumos_x_cursos_documentos__onblur(this, iSeqRow) })
                                         .bind('change', function() { sc_form_tb_insumos_x_cursos_documentos__onchange(this, iSeqRow) })
                                         .bind('focus', function() { sc_form_tb_insumos_x_cursos_documentos__onfocus(this, iSeqRow) });
  $('#id_sc_field_videos_' + iSeqRow).bind('blur', function() { sc_form_tb_insumos_x_cursos_videos__onblur(this, iSeqRow) })
                                     .bind('change', function() { sc_form_tb_insumos_x_cursos_videos__onchange(this, iSeqRow) })
                                     .bind('focus', function() { sc_form_tb_insumos_x_cursos_videos__onfocus(this, iSeqRow) });
  $('#id_sc_field_enbed_' + iSeqRow).bind('blur', function() { sc_form_tb_insumos_x_cursos_enbed__onblur(this, iSeqRow) })
                                    .bind('change', function() { sc_form_tb_insumos_x_cursos_enbed__onchange(this, iSeqRow) })
                                    .bind('focus', function() { sc_form_tb_insumos_x_cursos_enbed__onfocus(this, iSeqRow) });
  $('#id_sc_field_paginas_sugeridas_' + iSeqRow).bind('blur', function() { sc_form_tb_insumos_x_cursos_paginas_sugeridas__onblur(this, iSeqRow) })
                                                .bind('change', function() { sc_form_tb_insumos_x_cursos_paginas_sugeridas__onchange(this, iSeqRow) })
                                                .bind('focus', function() { sc_form_tb_insumos_x_cursos_paginas_sugeridas__onfocus(this, iSeqRow) });
  $('#id_sc_field_recomendaciones_' + iSeqRow).bind('blur', function() { sc_form_tb_insumos_x_cursos_recomendaciones__onblur(this, iSeqRow) })
                                              .bind('change', function() { sc_form_tb_insumos_x_cursos_recomendaciones__onchange(this, iSeqRow) })
                                              .bind('focus', function() { sc_form_tb_insumos_x_cursos_recomendaciones__onfocus(this, iSeqRow) });
  $('#id_sc_field_test_' + iSeqRow).bind('blur', function() { sc_form_tb_insumos_x_cursos_test__onblur(this, iSeqRow) })
                                   .bind('change', function() { sc_form_tb_insumos_x_cursos_test__onchange(this, iSeqRow) })
                                   .bind('focus', function() { sc_form_tb_insumos_x_cursos_test__onfocus(this, iSeqRow) });
} // scJQEventsAdd

function sc_form_tb_insumos_x_cursos_id_insumos__onblur(oThis, iSeqRow) {
  do_ajax_form_tb_insumos_x_cursos_validate_id_insumos_(iSeqRow);
  scCssBlur(oThis, iSeqRow);
}

function sc_form_tb_insumos_x_cursos_id_insumos__onchange(oThis, iSeqRow) {
  scMarkFormAsChanged();
  nm_check_insert(iSeqRow);
}

function sc_form_tb_insumos_x_cursos_id_insumos__onfocus(oThis, iSeqRow) {
  scEventControl_onFocus(oThis, iSeqRow);
  scCssFocus(oThis, iSeqRow);
}

function sc_form_tb_insumos_x_cursos_course_id__onchange(oThis, iSeqRow) {
  scMarkFormAsChanged();
}

function sc_form_tb_insumos_x_cursos_topico__onblur(oThis, iSeqRow) {
  do_ajax_form_tb_insumos_x_cursos_validate_topico_(iSeqRow);
  scCssBlur(oThis, iSeqRow);
}

function sc_form_tb_insumos_x_cursos_topico__onchange(oThis, iSeqRow) {
  scMarkFormAsChanged();
  nm_check_insert(iSeqRow);
}

function sc_form_tb_insumos_x_cursos_topico__onfocus(oThis, iSeqRow) {
  scEventControl_onFocus(oThis, iSeqRow);
  scCssFocus(oThis, iSeqRow);
}

function sc_form_tb_insumos_x_cursos_documentos__onblur(oThis, iSeqRow) {
  scCssBlur(oThis, iSeqRow);
}

function sc_form_tb_insumos_x_cursos_documentos__onchange(oThis, iSeqRow) {
  scMarkFormAsChanged();
  nm_check_insert(iSeqRow);
}

function sc_form_tb_insumos_x_cursos_documentos__onfocus(oThis, iSeqRow) {
  scCssFocus(oThis, iSeqRow);
}

function sc_form_tb_insumos_x_cursos_videos__onblur(oThis, iSeqRow) {
  do_ajax_form_tb_insumos_x_cursos_validate_videos_(iSeqRow);
  scCssBlur(oThis, iSeqRow);
}

function sc_form_tb_insumos_x_cursos_videos__onchange(oThis, iSeqRow) {
  scMarkFormAsChanged();
  nm_check_insert(iSeqRow);
}

function sc_form_tb_insumos_x_cursos_videos__onfocus(oThis, iSeqRow) {
  scEventControl_onFocus(oThis, iSeqRow);
  scCssFocus(oThis, iSeqRow);
}

function sc_form_tb_insumos_x_cursos_enbed__onblur(oThis, iSeqRow) {
  do_ajax_form_tb_insumos_x_cursos_validate_enbed_(iSeqRow);
  scCssBlur(oThis, iSeqRow);
}

function sc_form_tb_insumos_x_cursos_enbed__onchange(oThis, iSeqRow) {
  scMarkFormAsChanged();
  nm_check_insert(iSeqRow);
}

function sc_form_tb_insumos_x_cursos_enbed__onfocus(oThis, iSeqRow) {
  scEventControl_onFocus(oThis, iSeqRow);
  scCssFocus(oThis, iSeqRow);
}

function sc_form_tb_insumos_x_cursos_paginas_sugeridas__onblur(oThis, iSeqRow) {
  do_ajax_form_tb_insumos_x_cursos_validate_paginas_sugeridas_(iSeqRow);
  scCssBlur(oThis, iSeqRow);
}

function sc_form_tb_insumos_x_cursos_paginas_sugeridas__onchange(oThis, iSeqRow) {
  scMarkFormAsChanged();
  nm_check_insert(iSeqRow);
}

function sc_form_tb_insumos_x_cursos_paginas_sugeridas__onfocus(oThis, iSeqRow) {
  scEventControl_onFocus(oThis, iSeqRow);
  scCssFocus(oThis, iSeqRow);
}

function sc_form_tb_insumos_x_cursos_recomendaciones__onblur(oThis, iSeqRow) {
  do_ajax_form_tb_insumos_x_cursos_validate_recomendaciones_(iSeqRow);
  scCssBlur(oThis, iSeqRow);
}

function sc_form_tb_insumos_x_cursos_recomendaciones__onchange(oThis, iSeqRow) {
  scMarkFormAsChanged();
  nm_check_insert(iSeqRow);
}

function sc_form_tb_insumos_x_cursos_recomendaciones__onfocus(oThis, iSeqRow) {
  scEventControl_onFocus(oThis, iSeqRow);
  scCssFocus(oThis, iSeqRow);
}

function sc_form_tb_insumos_x_cursos_test__onblur(oThis, iSeqRow) {
  do_ajax_form_tb_insumos_x_cursos_validate_test_(iSeqRow);
  scCssBlur(oThis, iSeqRow);
}

function sc_form_tb_insumos_x_cursos_test__onchange(oThis, iSeqRow) {
  scMarkFormAsChanged();
  nm_check_insert(iSeqRow);
}

function sc_form_tb_insumos_x_cursos_test__onfocus(oThis, iSeqRow) {
  scEventControl_onFocus(oThis, iSeqRow);
  scCssFocus(oThis, iSeqRow);
}

function displayChange_block(block, status) {
	if ("0" == block) {
		displayChange_block_0(status);
	}
}

function displayChange_block_0(status) {
	displayChange_field("topico_", "", status);
	displayChange_field("documentos_", "", status);
	displayChange_field("videos_", "", status);
	displayChange_field("enbed_", "", status);
	displayChange_field("paginas_sugeridas_", "", status);
	displayChange_field("recomendaciones_", "", status);
	displayChange_field("test_", "", status);
}

function displayChange_row(row, status) {
	displayChange_field_topico_(row, status);
	displayChange_field_documentos_(row, status);
	displayChange_field_videos_(row, status);
	displayChange_field_enbed_(row, status);
	displayChange_field_paginas_sugeridas_(row, status);
	displayChange_field_recomendaciones_(row, status);
	displayChange_field_test_(row, status);
	displayChange_field_id_insumos_(row, status);
}

function displayChange_field(field, row, status) {
	if ("topico_" == field) {
		displayChange_field_topico_(row, status);
	}
	if ("documentos_" == field) {
		displayChange_field_documentos_(row, status);
	}
	if ("videos_" == field) {
		displayChange_field_videos_(row, status);
	}
	if ("enbed_" == field) {
		displayChange_field_enbed_(row, status);
	}
	if ("paginas_sugeridas_" == field) {
		displayChange_field_paginas_sugeridas_(row, status);
	}
	if ("recomendaciones_" == field) {
		displayChange_field_recomendaciones_(row, status);
	}
	if ("test_" == field) {
		displayChange_field_test_(row, status);
	}
	if ("id_insumos_" == field) {
		displayChange_field_id_insumos_(row, status);
	}
}

function displayChange_field_topico_(row, status) {
    var fieldId;
}

function displayChange_field_documentos_(row, status) {
    var fieldId;
}

function displayChange_field_videos_(row, status) {
    var fieldId;
}

function displayChange_field_enbed_(row, status) {
    var fieldId;
}

function displayChange_field_paginas_sugeridas_(row, status) {
    var fieldId;
}

function displayChange_field_recomendaciones_(row, status) {
    var fieldId;
}

function displayChange_field_test_(row, status) {
    var fieldId;
}

function displayChange_field_id_insumos_(row, status) {
    var fieldId;
}

function scRecreateSelect2() {
}
function scResetPagesDisplay() {
	$(".sc-form-page").show();
}

function scHidePage(pageNo) {
	$("#id_form_tb_insumos_x_cursos_form" + pageNo).hide();
}

function scCheckNoPageSelected() {
	if (!$(".sc-form-page").filter(".scTabActive").filter(":visible").length) {
		var inactiveTabs = $(".sc-form-page").filter(".scTabInactive").filter(":visible");
		if (inactiveTabs.length) {
			var tabNo = $(inactiveTabs[0]).attr("id").substr(32);
		}
	}
}
<?php

$formWidthCorrection = '';
if (false !== strpos($this->Ini->form_table_width, 'calc')) {
	$formWidthCalc = substr($this->Ini->form_table_width, strpos($this->Ini->form_table_width, '(') + 1);
	$formWidthCalc = substr($formWidthCalc, 0, strpos($formWidthCalc, ')'));
	$formWidthParts = explode(' ', $formWidthCalc);
	if (3 == count($formWidthParts) && 'px' == substr($formWidthParts[2], -2)) {
		$formWidthParts[2] = substr($formWidthParts[2], 0, -2) / 2;
		$formWidthCorrection = $formWidthParts[1] . ' ' . $formWidthParts[2];
	}
}

?>

function scSetFixedHeadersCss(baseTop)
{
    let rows, cols, i, j, thisTop;

    rows = $(".sc-ui-header-row");
    thisTop = baseTop;

    for (i = 0; i < rows.length; i++) {
        cols = $(rows[i]).find("td").filter(".sc-col-title");
        for (j = 0; j < cols.length; j++) {
            $(cols[j]).css({
                "position": "sticky",
                "top": thisTop + "px",
                "z-index": 4
            }).addClass("sc-header-fixed");
        }
        thisTop += $(rows[i]).height();
    }

    rows = $(".sc-ui-header-row");

    rows.filter(".sc-col-is-fixed").css("z-index", 5);
    rows.filter(".sc-col-is-fixed").filter(".sc-col-actions").css("z-index", 6);
}

$(function() {
    scSetFixedHeadersCss(0);
});

$(window).scroll(function() {
	scSetFixedHeaders();
});

var rerunHeaderDisplay = 1;

function scSetFixedHeaders(forceDisplay) {
    return;
	if (null == forceDisplay) {
		forceDisplay = false;
	}
	var divScroll, formHeaders, headerPlaceholder;
	formHeaders = scGetHeaderRow();
	headerPlaceholder = $("#sc-id-fixedheaders-placeholder");
	if (!formHeaders) {
		headerPlaceholder.hide();
	}
	else {
		if (scIsHeaderVisible(formHeaders)) {
			headerPlaceholder.hide();
		}
		else {
			if (!headerPlaceholder.filter(":visible").length || forceDisplay) {
				scSetFixedHeadersContents(formHeaders, headerPlaceholder);
				scSetFixedHeadersSize(formHeaders);
				headerPlaceholder.show();
			}
			scSetFixedHeadersPosition(formHeaders, headerPlaceholder);
			if (0 < rerunHeaderDisplay) {
				rerunHeaderDisplay--;
				setTimeout(function() {
					scSetFixedHeadersContents(formHeaders, headerPlaceholder);
					scSetFixedHeadersSize(formHeaders);
					headerPlaceholder.show();
					scSetFixedHeadersPosition(formHeaders, headerPlaceholder);
				}, 5);
			}
		}
	}
}

function scSetFixedHeadersPosition(formHeaders, headerPlaceholder) {
	if (formHeaders) {
		headerPlaceholder.css({"top": 0<?php echo $formWidthCorrection ?>, "left": (Math.floor(formHeaders.offset().left) - $(document).scrollLeft()<?php echo $formWidthCorrection ?>) + "px"});
	}
}

function scIsHeaderVisible(formHeaders) {
	if (typeof(scIsHeaderVisibleMobile) === typeof(function(){})) { return scIsHeaderVisibleMobile(formHeaders); }
	return formHeaders.offset().top > $(document).scrollTop();
}

function scGetHeaderRow() {
	var formHeaders = $(".sc-ui-header-row").filter(":visible");
	if (!formHeaders.length) {
		formHeaders = false;
	}
	return formHeaders;
}

function scSetFixedHeadersContents(formHeaders, headerPlaceholder) {
	var i, htmlContent;
	htmlContent = "<table id=\"sc-id-fixed-headers\" class=\"scFormTable\">";
	for (i = 0; i < formHeaders.length; i++) {
		htmlContent += "<tr class=\"scFormLabelOddMult\" id=\"sc-id-headers-row-" + i + "\">" + $(formHeaders[i]).html() + "</tr>";
	}
	htmlContent += "</table>";
	headerPlaceholder.html(htmlContent);
}

function scSetFixedHeadersSize(formHeaders) {
	var i, j, headerColumns, formColumns, cellHeight, cellWidth, tableOriginal, tableHeaders;
	tableOriginal = $("#hidden_bloco_0");
	tableHeaders = document.getElementById("sc-id-fixed-headers");
	$(tableHeaders).css("width", $(tableOriginal).outerWidth());
	for (i = 0; i < formHeaders.length; i++) {
		headerColumns = $("#sc-id-fixed-headers-row-" + i).find("td");
		formColumns = $(formHeaders[i]).find("td");
		for (j = 0; j < formColumns.length; j++) {
			if (window.getComputedStyle(formColumns[j])) {
				cellWidth = window.getComputedStyle(formColumns[j]).width;
				cellHeight = window.getComputedStyle(formColumns[j]).height;
			}
			else {
				cellWidth = $(formColumns[j]).width() + "px";
				cellHeight = $(formColumns[j]).height() + "px";
			}
			$(headerColumns[j]).css({
				"width": cellWidth,
				"height": cellHeight
			});
		}
	}
}
function scJQUploadAdd(iSeqRow) {
  $("#id_sc_field_documentos_" + iSeqRow).fileupload({
    datatype: "json",
    url: "form_tb_insumos_x_cursos_ul_save.php",
    dropZone: $("#hidden_field_data_documentos_" + iSeqRow),
    formData: function() {
      return [
        {name: 'param_field', value: 'documentos_'},
        {name: 'param_seq', value: '<?php echo $this->Ini->sc_page; ?>'},
        {name: 'upload_file_row', value: iSeqRow}
      ];
    },
    progress: function(e, data) {
      var loader, progress;
      if (data.lengthComputable && window.FormData !== undefined) {
        loader = $("#id_img_loader_documentos_" + iSeqRow);
        loaderContent = $("#id_img_loader_documentos_" + iSeqRow + " .scProgressBarLoading");
        loaderContent.html("&nbsp;");
        progress = parseInt(data.loaded / data.total * 100, 10);
        loader.show().find("div").css("width", progress + "%");
      }
      else {
        loader = $("#id_ajax_loader_documentos_" + iSeqRow);
        loader.show();
      }
    },
    done: function(e, data) {
      var fileData, respData, respPos, respMsg, thumbDisplay, checkDisplay, var_ajax_img_thumb, oTemp;
      fileData = null;
      respMsg = "";
      if (data && data.result && data.result[0] && data.result[0].body) {
        respData = data.result[0].body.innerText;
        respPos = respData.indexOf("[{");
        if (-1 !== respPos) {
          respMsg = respData.substr(0, respPos);
          respData = respData.substr(respPos);
          fileData = $.parseJSON(respData);
        }
        else {
          respMsg = respData;
        }
      }
      else {
        respData = data.result;
        respPos = respData.indexOf("[{");
        if (-1 !== respPos) {
          respMsg = respData.substr(0, respPos);
          respData = respData.substr(respPos);
          fileData = eval(respData);
        }
        else {
          respMsg = respData;
        }
      }
      if (window.FormData !== undefined)
      {
        $("#id_img_loader_documentos_" + iSeqRow).hide();
      }
      else
      {
        $("#id_ajax_loader_documentos_" + iSeqRow).hide();
      }
      if (null == fileData) {
        if ("" != respMsg) {
          oTemp = {"htmOutput" : "<?php echo $this->Ini->Nm_lang['lang_errm_upld_admn']; ?>"};
          scAjaxShowDebug(oTemp);
        }
        return;
      }
      if (fileData[0].error && "" != fileData[0].error) {
        var uploadErrorMessage = "";
        oResp = {};
        if ("acceptFileTypes" == fileData[0].error) {
          uploadErrorMessage = "<?php echo $this->form_encode_input($this->Ini->Nm_lang['lang_errm_file_invl']) ?>";
        }
        else if ("maxFileSize" == fileData[0].error) {
          uploadErrorMessage = "<?php echo $this->form_encode_input($this->Ini->Nm_lang['lang_errm_file_size']) ?>";
        }
        else if ("minFileSize" == fileData[0].error) {
          uploadErrorMessage = "<?php echo $this->form_encode_input($this->Ini->Nm_lang['lang_errm_file_size']) ?>";
        }
        else if ("emptyFile" == fileData[0].error) {
          uploadErrorMessage = "<?php echo $this->form_encode_input($this->Ini->Nm_lang['lang_errm_file_empty']) ?>";
        }
        scAjaxShowErrorDisplay("table", uploadErrorMessage);
        return;
      }
      $("#id_sc_field_documentos_" + iSeqRow).val("");
      $("#id_sc_field_documentos__ul_name" + iSeqRow).val(fileData[0].sc_ul_name);
      $("#id_sc_field_documentos__ul_type" + iSeqRow).val(fileData[0].type);
      $("#id_ajax_doc_documentos_" + iSeqRow).html(fileData[0].name);
      $("#id_ajax_doc_documentos_" + iSeqRow).css("display", "");
      checkDisplay = ("" == fileData[0].sc_random_prot.substr(12)) ? "none" : "";
      $("#chk_ajax_img_documentos_" + iSeqRow).css("display", checkDisplay);
      $("#id_ajax_link_documentos_" + iSeqRow).html(fileData[0].sc_random_prot.substr(12));
    }
  });

} // scJQUploadAdd

var api_cache_requests = [];
function ajax_check_file(img_name, field  ,t, p, p_cache, iSeqRow, hasRun, img_before){
    setTimeout(function(){
        if(img_name == '') return;
        iSeqRow= iSeqRow !== undefined && iSeqRow !== null ? iSeqRow : '';
        var hasVar = p.indexOf('_@NM@_') > -1 || p_cache.indexOf('_@NM@_') > -1 ? true : false;

        p = p.split('_@NM@_');
        $.each(p, function(i,v){
            try{
                p[i] = $('[name='+v+iSeqRow+']').val();
            }
            catch(err){
                p[i] = v;
            }
        });
        p = p.join('');

        p_cache = p_cache.split('_@NM@_');
        $.each(p_cache, function(i,v){
            try{
                p_cache[i] = $('[name='+v+iSeqRow+']').val();
            }
            catch(err){
                p_cache[i] = v;
            }
        });
        p_cache = p_cache.join('');

        img_before = img_before !== undefined ? img_before : $(t).attr('src');
        var str_key_cache = '<?php echo $this->Ini->sc_page; ?>' + img_name+field+p+p_cache;
        if(api_cache_requests[ str_key_cache ] !== undefined && api_cache_requests[ str_key_cache ] !== null){
            if(api_cache_requests[ str_key_cache ] != false){
                do_ajax_check_file(api_cache_requests[ str_key_cache ], field  ,t, iSeqRow);
            }
            return;
        }
        //scAjaxProcOn();
        $(t).attr('src', '<?php echo $this->Ini->path_icones ?>/scriptcase__NM__ajax_load.gif');
        api_cache_requests[ str_key_cache ] = false;
        var rs =$.ajax({
                    type: "POST",
                    url: 'index.php?script_case_init=<?php echo $this->Ini->sc_page; ?>',
                    async: true,
                    data:'nmgp_opcao=ajax_check_file&AjaxCheckImg=' + encodeURI(img_name) +'&rsargs='+ field + '&p=' + p + '&p_cache=' + p_cache,
                    success: function (rs) {
                        if(rs.indexOf('</span>') != -1){
                            rs = rs.substr(rs.indexOf('</span>') + 7);
                        }
                        if(rs.indexOf('/') != -1 && rs.indexOf('/') != 0){
                            rs = rs.substr(rs.indexOf('/'));
                        }
                        rs = sc_trim(rs);

                        // if(rs == 0 && hasVar && hasRun === undefined){
                        //     delete window.api_cache_requests[ str_key_cache ];
                        //     ajax_check_file(img_name, field  ,t, p, p_cache, iSeqRow, 1, img_before);
                        //     return;
                        // }
                        window.api_cache_requests[ str_key_cache ] = rs;
                        do_ajax_check_file(rs, field  ,t, iSeqRow)
                        if(rs == 0){
                            delete window.api_cache_requests[ str_key_cache ];

                           // $(t).attr('src',img_before);
                            do_ajax_check_file(img_before+'_@@NM@@_' + img_before, field  ,t, iSeqRow)

                        }


                    }
        });
    },100);
}

function do_ajax_check_file(rs, field  ,t, iSeqRow){
    if (rs != 0) {
        rs_split = rs.split('_@@NM@@_');
        rs_orig = rs_split[0];
        rs2 = rs_split[1];
        try{
            if(!$(t).is('img')){

                if($('#id_read_on_'+field+iSeqRow).length > 0 ){
                                    var usa_read_only = false;

                switch(field){

                }
                     if(usa_read_only && $('a',$('#id_read_on_'+field+iSeqRow)).length == 0){
                         $(t).html("<a href=\"javascript:nm_mostra_doc('0', '"+rs2+"', 'form_tb_insumos_x_cursos')\">"+$('#id_read_on_'+field+iSeqRow).text()+"</a>");
                     }
                }
                if($('#id_ajax_doc_'+field+iSeqRow+' a').length > 0){
                    var target = $('#id_ajax_doc_'+field+iSeqRow+' a').attr('href').split(',');
                    target[1] = "'"+rs2+"'";
                    $('#id_ajax_doc_'+field+iSeqRow+' a').attr('href', target.join(','));
                }else{
                    var target = $(t).attr('href').split(',');
                     target[1] = "'"+rs2+"'";
                     $(t).attr('href', target.join(','));
                }
            }else{
                $(t).attr('src', rs2);
                $(t).css('display', '');
                if($('#id_ajax_doc_'+field+iSeqRow+' a').length > 0){
                    var target = $('#id_ajax_doc_'+field+iSeqRow+' a').attr('href').split(',');
                    target[1] = "'"+rs2+"'";
                    $(t).attr('href', target.join(','));
                }else{
                     var t_link = $(t).parent('a');
                     var target = $(t_link).attr('href').split(',');
                     target[0] = "javascript:nm_mostra_img('"+rs_orig+"'";
                     $(t_link).attr('href', target.join(','));
                }

            }
            eval("window.var_ajax_img_"+field+iSeqRow+" = '"+rs_orig+"';");

        } catch(err){
                        eval("window.var_ajax_img_"+field+iSeqRow+" = '"+rs_orig+"';");

        }
    }
   /* hasFalseCacheRequest = false;
    $.each(api_cache_requests, function(i,v){
        if(v == false){
            hasFalseCacheRequest = true;
        }
    });
    if(hasFalseCacheRequest == false){
        scAjaxProcOff();
    }*/
}

$(document).ready(function(){
});

function scJQPasswordToggleAdd(seqRow) {
  $(".sc-ui-pwd-toggle-icon" + seqRow).on("click", function() {
    var fieldName = $(this).attr("id").substr(17), fieldObj = $("#id_sc_field_" + fieldName), fieldFA = $("#id_pwd_fa_" + fieldName);
    if ("text" == fieldObj.attr("type")) {
      fieldObj.attr("type", "password");
      fieldFA.attr("class", "fa fa-eye sc-ui-pwd-eye");
    } else {
      fieldObj.attr("type", "text");
      fieldFA.attr("class", "fa fa-eye-slash sc-ui-pwd-eye");
    }
  });
} // scJQPasswordToggleAdd

function scJQSelect2Add(seqRow, specificField) {
} // scJQSelect2Add


function scJQElementsAdd(iLine) {
  scJQEventsAdd(iLine);
  scEventControl_init(iLine);
  scJQUploadAdd(iLine);
  scJQPasswordToggleAdd(iLine);
  scJQSelect2Add(iLine);
} // scJQElementsAdd

function scGetFileExtension(fileName)
{
    fileNameParts = fileName.split(".");

    if (1 === fileNameParts.length || (2 === fileNameParts.length && "" == fileNameParts[0])) {
        return "";
    }

    return fileNameParts.pop().toLowerCase();
}

function scFormatExtensionSizeErrorMsg(errorMsg)
{
    var msgInfo = errorMsg.split("||"), returnMsg = "";

    if ("err_size" == msgInfo[0]) {
        returnMsg = "<?php echo $this->Ini->Nm_lang['lang_errm_file_size'] ?>. <?php echo $this->Ini->Nm_lang['lang_errm_file_size_extension'] ?>".replace("{SC_EXTENSION}", msgInfo[1]).replace("{SC_LIMIT}", msgInfo[2]);
    } else if ("err_extension" == msgInfo[0]) {
        returnMsg = "<?php echo $this->Ini->Nm_lang['lang_errm_file_invl'] ?>";
    }

    return returnMsg;
}

