
    <!-- DataTables -->
    <link rel="stylesheet" type="text/css" href="../assets/media/css/dataTables.bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../assets/media/css/dataTables.responsive.css">
    <script type="text/javascript" language="javascript" src="../assets/media/js/jquery.dataTables.js"></script>
    <script type="text/javascript" language="javascript" src="../assets/media/js/dataTables.responsive.js"></script>
    <script type="text/javascript" language="javascript" src="../assets/media/js/dataTables.bootstrap.js"></script>
    <script type="text/javascript" language="javascript" src="../assets/media/js/common.js"></script>
    <script type="text/javascript" language="javascript" >
      
      var dTable;
      // #data adalah id pada table
      $(document).ready(function() {
        dTable = $('#data').DataTable( {
          "bProcessing": true,
          "bServerSide": true,
          "bJQueryUI": false,
          "responsive": true,
          "sAjaxSource": "serverSide-data.php", // Load Data
          "sServerMethod": "POST",
          "columnDefs": [
          { "orderable": false, "targets": 0, "searchable": false },
          { "orderable": true, "targets": 1, "searchable": true },
          { "orderable": true, "targets": 2, "searchable": true },
          { "orderable": true, "targets": 3, "searchable": true },
          { "orderable": true, "targets": 4, "searchable": true }
          ]
        } );
        
        $('#data').removeClass( 'display' ).addClass('table table-striped table-bordered');
        $('#data thead th').each( function () {
          
          //Agar kolom Action Tidak Ada Tombol Pencarian
          if( $(this).text() != "Action" ){
            var title = $('#data thead th').eq( $(this).index() ).text();
            $(this).html( '<input type="text" placeholder="Search '+title+'" class="form-control" />' );
          }
        } );
        
        // Untuk Pencarian, di kolom paling bawah
        dTable.columns().every( function () {
          var that = this;
          
          $( 'input', this.footer() ).on( 'keyup change', function () {
            that
            .search( this.value )
            .draw();
          } );
        } );
      } );
      
      
    </script>
    <div class="container-fluid">
      <div class="row">
        <div class="col-md-12">
      <!-- Main component for a primary marketing message or call to action -->
      <div class="page-header">
      <button onClick="showModalsdata()" class="btn btn-primary">Tambah Data</button>
      <a class="btn btn-danger" href="cetak-data.php" role="button">Cetak PDF</a>
      </div>
          <table id="data"  cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
            <thead>
              <tr>
                <th>Action</th>
                <th>NIS</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>No Telepon</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
                <th>Action</th>
                <th>NIS</th>
                <th>Nama</th>
                <th>Kelas</th>
                <th>No Telepon</th>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
    
    <!-- Modal Popup -->
    <div class="modal fade" id="dataModals" tabindex="-1" role="dialog" aria-labelledby="dataModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" onclick="clearModals()" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="dataModalLabel">Add User</h4>
          </div>
          <div class="modal-body">
            <form class="form-horizontal" id="formDataSiswa">
              <input type="hidden" class="form-control" id="type" name="type">
              <div class="form-group">
                <label for="nis" class="col-sm-2 control-label">NIS</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="nis" name="nis">
                </div>
              </div>
              <div class="form-group">
                <label for="nama" class="col-sm-2 control-label">NAMA</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="nama" name="nama" >
                </div>
              </div>
              <div class="form-group">
                <label for="kelas" class="col-sm-2 control-label">KELAS</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="kelas" name="kelas" >
                </div>
              </div>
              <div class="form-group">
                <label for="telepon" class="col-sm-2 control-label">No. Telepon</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="telepon" name="telepon" >
                </div>
              </div>
            </form>
            
          </div>
          <div class="modal-footer">
            <button type="button" onClick="submitData()" class="btn btn-default" data-dismiss="modal">Submit</button>
            <button type="button" onclick="clearModals()" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    
    <script>
    
        //Tampilkan Modal 
      function showModalsdata( nis )
      {
        waitingDialog.show();
        clearModals();
        
        // Untuk Eksekusi Data Yang Ingin di Edit atau Di Hapus 
        if(nis)
        {
          $.ajax({
            type: "POST",
            url: "crud.php",
            dataType: 'json',
            data: {nis:nis,type:"get"},
            success: function(res) {
              waitingDialog.hide();
              setModalData_data( res );
            }
          });
        }
        // Untuk Tambahkan Data
        else
        {
          $("#dataModals").modal("show");
          $("#dataModalLabel").html("New User");
          $("#type").val("new"); 
          waitingDialog.hide();
        }
      }
      
      //Data Yang Ingin Di Tampilkan Pada Modal Ketika Di Edit 
      function setModalData_data( data )
      {
        $("#dataModalLabel").html(data.nama);
        $("#removeWarning").hide();
        $("#nis").val(data.nis);
        $("#nama").val(data.nama);
        $("#type").val("edit");
        $("#kelas").val(data.kelas);
        $("#telepon").val(data.telepon);
        $("#dataModals").modal("show");
      }
      
      //Submit Untuk Eksekusi Tambah/Edit/Hapus Data 
      function submitData()
      {
        var formData = $("#formDataSiswa").serialize();
        waitingDialog.show();
        $.ajax({
          type: "POST",
          url: "crud.php",
          dataType: 'json',
          data: formData,
          success: function(data) {
            dTable.ajax.reload(); // Untuk Reload Tables secara otomatis
            waitingDialog.hide(); 
          }
        });
      }
      
      //Hapus Data
      function deleteUser( nis )
      {
        clearModals();
        $.ajax({
          type: "POST",
          url: "crud.php",
          dataType: 'json',
          data: {nis:nis,type:"get"},
          success: function(data) {
            $("#removeWarning").show();
            $("#dataModalLabel").html("Delete User");
            $("#nis").val(data.nis);
            $("#type").val("delete");
            $("#kelas").val(data.kelas).attr("disabled","true");
            $("#nama").val(data.nama).attr("disabled","true");
            $("#telepon").val(data.telepon).attr("disabled","true");
            $("#dataModals").modal("show");
            waitingDialog.hide();     
          }
        });
      }
      
      //Clear Modal atau menutup modal supaya tidak terjadi duplikat modal
      function clearModals()
      {
        $("#removeWarning").hide();
        $("#nis").val("").removeAttr( "disabled" );
        $("#nama").val("").removeAttr( "disabled" );
        $("#kelas").val("").removeAttr( "disabled" );
        $("#telepon").val("").removeAttr( "disabled" );
        $("#type").val("");
      }
      
    </script>
        <!-- Akhir Tabel -->
