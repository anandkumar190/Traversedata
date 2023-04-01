
<table id="tbl_exporttable_to_xls" border="1">
	<thead>
		<th>Sr</th>
		<th>Name</th>
	</thead>
	<tbody>
    @foreach($data as $key=>$row)
        <tr>
            <td>{{ $key }}</td>
            <td>{{ $row }}</td>
        </tr>
        @endforeach         
	</tbody>
</table>
<button onclick="ExportToExcel('xlsx')">Export table to excel</button>

<script type="text/javascript" src="https://unpkg.com/xlsx@0.15.1/dist/xlsx.full.min.js"></script>

<script>
    function ExportToExcel(type, fn, dl) {
       var elt = document.getElementById('tbl_exporttable_to_xls');
       var wb = XLSX.utils.table_to_book(elt, { sheet: "sheet1" });
       return dl ?
         XLSX.write(wb, { bookType: type, bookSST: true, type: 'base64' }):
         XLSX.writeFile(wb, fn || ('MySheetName.' + (type || 'xlsx')));
    }
</script>
