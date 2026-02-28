@extends('layouts.MainLayout')

@push('blade_style')
  <style>
        table {
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #333;
            padding: 8px 12px;
        }
        input[type="text"] {
            padding: 5px;
            width: 100%;
        }
        .btn {
            padding: 6px 12px;
            margin: 5px 0;
            cursor: pointer;
        }
    </style>
@endpush
@section('content')

<form action="" id="form_create" action="POST">
   
<div id="tableContainer">
    <div>
        <span>
             <input type="text" class="form-control" placeholder="Table name" name="table_name" style="width: 30%;">
        </span>
        <span id="table_validation">

        </span>
       
    </div>
      <button type="button" id="addRow" class="btn btn-primary">Add Row</button>
      <br>
      <br>
    <i>id will be default value</i>
    <table id="myTable">
        <tr>
            <td><input class="form-control" type="text" name="colum_name[]" placeholder="Enter value"></td>
            <td>  <select class="form-select" id="dataType" name="data_type[]">
            <option value="INT">INT</option>
            <option value="BIGINT">BIGINT</option>
            <option value="SMALLINT">SMALLINT</option>
            <option value="TINYINT">TINYINT</option>
            <option value="DECIMAL">DECIMAL</option>
            <option value="NUMERIC">NUMERIC</option>
            <option value="FLOAT">FLOAT</option>
            <option value="DOUBLE">DOUBLE</option>
            <option value="REAL">REAL</option>
            <option value="CHAR">CHAR</option>
            <option value="VARCHAR">VARCHAR</option>
            <option value="TEXT">TEXT</option>
            <option value="TINYTEXT">TINYTEXT</option>
            <option value="MEDIUMTEXT">MEDIUMTEXT</option>
            <option value="LONGTEXT">LONGTEXT</option>
            <option value="DATE">DATE</option>
            <option value="DATETIME">DATETIME</option>
            <option value="TIMESTAMP">TIMESTAMP</option>
            <option value="TIME">TIME</option>
            <option value="YEAR">YEAR</option>
            <option value="BOOLEAN">BOOLEAN</option>
            <option value="ENUM">ENUM</option>
            <option value="SET">SET</option>
            <option value="BLOB">BLOB</option>
            <option value="TINYBLOB">TINYBLOB</option>
            <option value="MEDIUMBLOB">MEDIUMBLOB</option>
            <option value="LONGBLOB">LONGBLOB</option>
        </select></td>
        </tr>
    </table>
  
    
</div>

<br>
<button class="btn btn-success" type="submit">Create table</button>
</form>

@endsection
@section('scripts')
<script>
$(document).ready(function() {
    console.log('loaded')
    $('#addRow').click(function() {

        var newRow = `<tr>
            <td><input class="form-control" type="text" name="colum_name[]" placeholder="Enter value"></td>
            <td>  <select class="form-select" name="data_type[]" id="dataType">
            <option value="INT">INT</option>
            <option value="BIGINT">BIGINT</option>
            <option value="SMALLINT">SMALLINT</option>
            <option value="TINYINT">TINYINT</option>
            <option value="DECIMAL">DECIMAL</option>
            <option value="NUMERIC">NUMERIC</option>
            <option value="FLOAT">FLOAT</option>
            <option value="DOUBLE">DOUBLE</option>
            <option value="REAL">REAL</option>
            <option value="CHAR">CHAR</option>
            <option value="VARCHAR">VARCHAR</option>
            <option value="TEXT">TEXT</option>
            <option value="TINYTEXT">TINYTEXT</option>
            <option value="MEDIUMTEXT">MEDIUMTEXT</option>
            <option value="LONGTEXT">LONGTEXT</option>
            <option value="DATE">DATE</option>
            <option value="DATETIME">DATETIME</option>
            <option value="TIMESTAMP">TIMESTAMP</option>
            <option value="TIME">TIME</option>
            <option value="YEAR">YEAR</option>
            <option value="BOOLEAN">BOOLEAN</option>
            <option value="ENUM">ENUM</option>
            <option value="SET">SET</option>
            <option value="BLOB">BLOB</option>
            <option value="TINYBLOB">TINYBLOB</option>
            <option value="MEDIUMBLOB">MEDIUMBLOB</option>
            <option value="LONGBLOB">LONGBLOB</option>
        </select></td>`;

        $('#myTable').append(newRow);
    });
});
</script>
@endsection