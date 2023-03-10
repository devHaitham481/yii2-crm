    /*
Bootstable
 @description  Javascript library to make HMTL tables editable, using Bootstrap
 @version 1.1
 @autor Tito Hinostroza
*/
  "use strict";
  //Global variables
  var params = null;  		//Parameters
  var colsEdi =null;
  var newColHtml = '<div class="btn-group pull-right">'+
'<button id="bEdit" type="button" class="btn btn-sm btn-default"  onclick="rowEdit(this);">' +
'<i class="fas fa-pencil-alt"></i>'+
'</button>'+
'<button id="bElim" type="button" class="btn btn-sm btn-default"  onclick="rowElim(this);">' +
'<i class="fas fa-trash" aria-hidden="true"></i>'+
'</button>'+
'<button id="bAcep" type="button" class="btn btn-sm btn-default"  style="display:none;" onclick="rowAcep(this);">' + 
'<i class="fas fa-check"></i>'+
'</button>'+
'<button id="bCanc" type="button" class="btn btn-sm btn-default" style="display:none;"  onclick="rowCancel(this);">' + 
'<i class="fas fa-times" aria-hidden="true"></i>'+
'</button>'+
    '</div>';

     var saveColHtml = '<div class="btn-group pull-right">'+
'<button id="bEdit" type="button" class="btn btn-sm btn-default" style="display:none;" onclick="rowEdit(this);">' +
'<i class="fas fa-pencil-alt"></i>'+
'</button>'+
'<button id="bElim" type="button" class="btn btn-sm btn-default" style="display:none;" onclick="rowElim(this);">' +
'<i class="fas fa-trash" aria-hidden="true"></i>'+
'</button>'+
'<button id="bAcep" type="button" class="btn btn-sm btn-default"   onclick="rowAcep(this);">' + 
'<i class="fas fa-check"></i>'+
'</button>'+
'<button id="bCanc" type="button" class="btn btn-sm btn-default"  onclick="rowCancel(this);">' + 
'<i class="fas fa-times" aria-hidden="true"></i>'+
'</button>'+
    '</div>';
  var colEdicHtml = '<td name="buttons">'+newColHtml+'</td>'; 
var colSaveHtml = '<td name="buttons">'+saveColHtml+'</td>';
    
  $.fn.SetEditable = function (options) {
    var defaults = {
        columnsEd: null,         //Index to editable columns. If null all td editables. Ex.: "1,2,3,4,5"
        $addButton: null,        //Jquery object of "Add" button
        onEdit: function() {},   //Called after edition
		onBeforeDelete: function() {}, //Called before deletion
        onDelete: function() {}, //Called after deletion
        onAdd: function() {}     //Called when added a new row
    };
    params = $.extend(defaults, options);
    this.find('thead tr[data-target="#demo1"]').append('<th name="buttons"></th>');  //encabezado vac??o
    this.find('tbody tr[data-target="#demo1"]').append(colEdicHtml);
    // this.find('tbody tr[data-target="#demo2"]').append('<th name="buttons"></th>');
    // this.find('tbody tr[data-target="#demo2"]').append(colEdicHtml);    
	var $tabedi = this;   //Read reference to the current table, to resolve "this" here.
    //Process "addButton" parameter
    if (params.$addButton != null) {
        //Se proporcion?? par??metro
        params.$addButton.click(function() {
            rowAddNew($tabedi.attr("id"));
        });
    }
    //Process "columnsEd" parameter
    if (params.columnsEd != null) {
        //Extract felds
        colsEdi = params.columnsEd.split(',');
    }
  };
function IterarCamposEdit($cols, tarea) {
//Itera por los campos editables de una fila
    var n = 0;
    $cols.each(function() {
        n++;
        if ($(this).attr('name')=='buttons') return;  //excluye columna de botones
        if (!EsEditable(n-1)) return;   //noe s campo editable
        tarea($(this));
    });
    
    function EsEditable(idx) {
    //Indica si la columna pasada est?? configurada para ser editable
        if (colsEdi==null) {  //no se defini??
            return true;  //todas son editable
        } else {  //hay filtro de campos
//alert('verificando: ' + idx);
            for (var i = 0; i < colsEdi.length; i++) {
              if (idx == colsEdi[i]) return true;
            }
            return false;  //no se encontr??
        }
    }
}
function FijModoNormal(but) {
    $(but).parent().find('#bAcep').hide();
    $(but).parent().find('#bCanc').hide();
    $(but).parent().find('#bEdit').show();
    $(but).parent().find('#bElim').show();
    var $row = $(but).parents('tr');  //accede a la fila
    $row.attr('id', '');  //quita marca
}
function FijModoEdit(but) {

    $(but).parent().find('#bAcep').show();
    $(but).parent().find('#bCanc').show();
    $(but).parent().find('#bEdit').hide();
    $(but).parent().find('#bElim').hide();
    var $row = $(but).parents('tr'); //accede a la fila
    console.log($row);
    $row.attr('id', 'editing');  //indica que est?? en edici??n
}
function ModoEdicion($row) {
    if ($row.attr('id')=='editing') {
        return true;
    } else {
        return false;
    }
}
function rowAcep(but) {
//Acepta los cambios de la edici??n
    // console.log(dropDownItems);
    
    var $row = $(but).parents('tr');  //accede a la fila
    var $cols = $row.find('td');  //lee campos
    console.warn($cols);
    if (!ModoEdicion($row)) return;  //Ya est?? en edici??n
    //Est?? en edici??n. Hay que finalizar la edici??n
    IterarCamposEdit($cols, function($td) {  //itera por la columnas
      var cont = $td.find('input, select'); //lee contenido del input

      $td.data('real-value', cont.val());
      if(cont.prop("tagName") == 'SELECT') {
          cont = cont.children(':selected').text();
      }
      else {
          cont = cont.val(); 
      } 
      $td.html(cont);  //fija contenido y elimina controles
    });
    FijModoNormal(but);
    params.onEdit($row);
}
function rowCancel(but) {
//Rechaza los cambios de la edici??n
    var $row = $(but).parents('tr');  //accede a la fila
    var $cols = $row.find('td');  //lee campos
    if (!ModoEdicion($row)) return;  //Ya est?? en edici??n
    //Est?? en edici??n. Hay que finalizar la edici??n
    IterarCamposEdit($cols, function($td) {  //itera por la columnas
        var cont = $td.find('div').html(); //lee contenido del div
        $td.html(cont);  //fija contenido y elimina controles
    });
    FijModoNormal(but);
}
function rowEdit(but) {  
    var $td = $("tr[id='editing'] td");
    rowAcep($td)
    var $row = $(but).parents('tr');  
    var $cols = $row.find('td');
    if (ModoEdicion($row)) return;  //Ya est?? en edici??n
    //Pone en modo de edici??n
    IterarCamposEdit($cols, function($td) {  //itera por la columnas
        var cont = $td.html(); //lee contenido
        var div = '<div style="display: none;">' + cont + '</div>';  //guarda contenido
        var input = '<input class="form-control input-sm"  value="' + cont + '">';
        // var dropDownItems = dropDownItems    || [];
        if($($td).attr("is_dropdown") == '1'){
            // console.log(dropDownItems);
            var input = `<select class="form-control">`;
                       
             dropDownItems.forEach((item, key) => {
                input= input + `<option value="${key}">${item}</option>`;
            })
            input= input + `</select>`;
        }
        else {
        }
        $td.html(div + input);  //fija contenido
    });
    FijModoEdit(but);
}
function rowElim(but) {  //Elimina la fila actual
    var $row = $(but).parents('tr');  //accede a la fila
    params.onBeforeDelete($row);
    $row.remove();
    params.onDelete();
}
function rowAddNew(tabId) {  //Agrega fila a la tabla indicada.
var $tab_en_edic = $("#" + tabId);  //Table to edit
    var $filas = $tab_en_edic.find('tbody tr');
    if ($filas.length==0) {
        //No hay filas de datos. Hay que crearlas completas
        var $row = $tab_en_edic.find('thead tr');  //encabezado
        var $cols = $row.find('th');  //lee campos
        //construye html
        var htmlDat = '';
        $cols.each(function() {
            if ($(this).attr('name')=='buttons') {
                //Es columna de botones
                htmlDat = htmlDat + colEdicHtml;  //agrega botones
            } else {
                htmlDat = htmlDat + '<td></td>';
            }
        });
        $tab_en_edic.find('tbody').append('<tr>'+htmlDat+'</tr>');
    } else {
        //Hay otras filas, podemos clonar la ??ltima fila, para copiar los botones
        var $ultFila = $tab_en_edic.find('tr:last');
        $ultFila.clone().appendTo($ultFila.parent()); 
        $tab_en_edic.find('tr:last').attr('id','editing'); 
        $ultFila = $tab_en_edic.find('tr:last');
        var $cols = $ultFila.find('td');  //lee campos
        
        $cols.each(function() {
            if ($(this).attr('name')=='buttons') {
                //Es columna de botones
            } else {
                var div = '<div style="display: none;"></div>';  //guarda contenido
                var input = '<input class="form-control input-sm"  value="">';

                $(this).html(div + input);  //limpia contenido
            }
        });
         $ultFila.find('td:last').html(saveColHtml);

    }
	params.onAdd();
}
function TableToCSV(tabId, separator) {  //Convierte tabla a CSV
    var datFil = '';
    var tmp = '';
	var $tab_en_edic = $("#" + tabId);  //Table source
    $tab_en_edic.find('tbody tr').each(function() {
        //Termina la edici??n si es que existe
        if (ModoEdicion($(this))) {
            $(this).find('#bAcep').click();  //acepta edici??n
        }
        var $cols = $(this).find('td');  //lee campos
        datFil = '';
        $cols.each(function() {
            if ($(this).attr('name')=='buttons') {
                //Es columna de botones
            } else {
                datFil = datFil + $(this).html() + separator;
            }
        });
        if (datFil!='') {
            datFil = datFil.substr(0, datFil.length-separator.length); 
        }
        tmp = tmp + datFil + '\n';
    });
    return tmp;
}
