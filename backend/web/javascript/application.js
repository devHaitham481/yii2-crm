$('.accordion-toggle').click(function(){
    $('.hiddenRow').hide();
    $(this).next('tr').find('.hiddenRow').show();
    });

  
  
    const $tableID = $('#table'); const $BTN = $('#export-btn'); const $EXPORT = $('#export');
    const newTr = `
    <tr class="hide">
      <td class="pt-3-half" contenteditable="true">Example</td>
      <td class="pt-3-half" contenteditable="true">Example</td>
      <td class="pt-3-half" contenteditable="true">Example</td>
      <td class="pt-3-half" contenteditable="true">Example</td>
      <td class="pt-3-half" contenteditable="true">Example</td>
      <td class="pt-3-half">
        <span class="table-up"
          ><a href="#!" class="indigo-text"
            ><i class="fas fa-long-arrow-alt-up" aria-hidden="true"></i></a
        ></span>
        <span class="table-down"
          ><a href="#!" class="indigo-text"
            ><i class="fas fa-long-arrow-alt-down" aria-hidden="true"></i></a
        ></span>
      </td>
      <td>
        <span class="table-remove"
          ><button
            type="button"
            class="btn btn-danger btn-rounded btn-sm my-0 waves-effect waves-light"
          >
            Remove
          </button></span
        >
      </td>
    </tr>`; 
    $('.table-add').on('click', 'i', () => { const $clone = $tableID.find('tbody tr').last().clone(true).removeClass('hide table-line'); if ($tableID.find('tbody tr').length === 0) { $('tbody').append(newTr); } $tableID.find('table').append($clone); });
    $tableID.on('click', '.table-remove', function () { $(this).parents('tr').detach(); });
    $tableID.on('click', '.table-up', function () { const $row = $(this).parents('tr'); if
    ($row.index() === 0) { return; } $row.prev().before($row.get(0)); }); $tableID.on('click',
    '.table-down', function () { const $row = $(this).parents('tr');
    $row.next().after($row.get(0)); }); // A few jQuery helpers for exporting only 
    jQuery.fn.pop = [].pop; jQuery.fn.shift = [].shift; $BTN.on('click', () => { const $rows =
    $tableID.find('tr:not(:hidden)'); const headers = []; const data = []; // Get the headers
    $($rows.shift()).find('th:not(:empty)').each(function () {
    headers.push($(this).text().toLowerCase()); }); // Turn all existing rows into a loopable
     $rows.each(function () { const $td = $(this).find('td'); const h = {}; // Use the
    headers.forEach((header, i) => { h[header] =
    $td.eq(i).text(); }); data.push(h); }); // Output the result
    $EXPORT.text(JSON.stringify(data)); });


//   $('#makeEditable').SetEditable({ 
//     $addButton: $('#but_add'),
//     columnsEd: "0,1,2,3,4,5,6,7"
//   });
  // $('#innerTable').SetEditable({
  //   $addButton: $('#but_add'),
  //   columnsEd: "0,1,2,3,4,5,6"
  // })
  $(document).ready(function(){
    $("#searchInput").on("keyup", function() {
      var value = $(this).val();
      console.log(value);
      $("#makeEditable tr").filter(function() {
        console.log("initiate filter");
        $(this).toggle($(this).text().indexOf(value) > -1)
      });
    });   
  });

    $(document.body).on('click', "#bAcep", function(event) {
        event.preventDefault(); // stopping submitting
        let trElement = $(this).closest("tr"); 
        let elements = ($("[hit-data]", trElement));
        let arr = {}; 

        elements.each(($index, $e) => {
          arr[$($e).attr("hit-data")] = $($e).data('real-value');
          
        });

        arr['id'] = trElement.attr("hit-data-id");
        console.log($(this).closest("tr"));
        console.log(project_id, entityTable);
        var url = `/crm/backend/web/index.php?r=entity%2Fupdate-entity-row&project_id=${project_id}&entityTable=${entityTable}`;
         
         $.ajax({
             url: url,
             type: 'post',
             dataType: 'json',
             data: arr
         })
         .done(function(response) {
             if (response.status == 200) {
                 alert("Done!");
             }
         })
         .fail(function(response) {
           console.log(response);
             alert("error!");
         });
         
     });

  function edit_branch_row(e) {
    var table = document.getElementById('innerTable'); 

    var rowData = e.parentElement.parentElement.querySelectorAll("td#field")
    var modal = document.querySelectorAll('#modalForm > .modalInput');

    rowData.forEach((row, index) => {

      if(index == 0){
        return;
      }
      modal[index - 1].value = row.innerText;
      console.log(row.innerText, modal[index - 1]);
    });

    }

    let counter = 0; 
    function checkValue(val){
      console.log("REACHED checkValue");
      var select = document.getElementById('columnTypes');
      let html = '<div class="form-group dropdownInputs"><div class="row"><input type="number" name="DropDownListKey[][key]" class="form-control col-6" placeholder="أدخل المفتاح"><input class="typeInput form-control col-6" name="DropDownListName[][name]" type="text" id="inlineGridName" placeholder="أدخل القيمة"><a class= "btn" href="javascript:void(0);" onclick="addField(this)"><i class="fas fa-plus"></a></i></div>';
      var test = document.querySelector('.field-columnTypes'); 
      var text = select.options[select.selectedIndex].text;
      if(text === 'dropdown'){
        console.log("reached condition");
        test.insertAdjacentHTML('afterend', html);

      }
      else {
        $(".dropdownInputs").remove();
      }
      counter++;
    }
    // $(document).ready(function(){
    //   var addField = $('add_button'); 
    //   var wrapper = $('.field_wrapper');
    //   var fieldHTML
    // })
    

    function addField(val){

      console.log("REACHED ADD FIELD"); 
      // id="entitycolumn-source_table" name="EntityColumn[source_table]" 
      let input = document.createElement('input'); 
      var attributes = ["class", "type", "value"]; 
      var values = ["form-group"];
      input.setAttribute('type', 'text');
      input.setAttribute('name', 'item');
      wrapper = document.querySelector('.dropdownInputs');
      console.log(wrapper);
      let html = '<div class="form-group row"><input type="number" name="DropDownListKey[][key]" class="form-control col-6"><input type="text" name="DropDownListName[][name]" id="inlineGridName" class="form-control col-6" placeholder="أدخل القيمة"><a class="btn" onclick="removeField(this)"><i class="fas fa-minus" "></a></i></div>';
      wrapper.insertAdjacentHTML('afterend', html);
      counter++;
      console.log("wrapper appended");
    }
    function removeField(val) {
     let parentElement = val.parentElement; 
     parentElement.remove();
      
    }



    

