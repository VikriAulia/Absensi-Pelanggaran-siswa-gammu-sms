
    <!-- DataTables -->
    <link rel="stylesheet" type="text/css" href="assets/media/css/dataTables.bootstrap.css">
    <link rel="stylesheet" type="text/css" href="assets/media/css/dataTables.responsive.css">
    <script type="text/javascript" language="javascript" src="assets/media/js/jquery.dataTables.js"></script>
    <script type="text/javascript" language="javascript" src="assets/media/js/dataTables.responsive.js"></script>
    <script type="text/javascript" language="javascript" src="assets/media/js/dataTables.bootstrap.js"></script>
    <script type="text/javascript" language="javascript" src="assets/media/js/common.js"></script>
    <script type="text/javascript" language="javascript" >
      
      var dTable;
      // #student adalah id pada table
      $(document).ready(function() {
        dTable = $('#student').DataTable( {
          "bProcessing": true,
          "bServerSide": true,
          "bJQueryUI": false,
          "responsive": true,
          "sAjaxSource": "assets/server/serverSide-absen.php", // Load Data
          "sServerMethod": "POST",
          "columnDefs": [
          { "orderable": false, "targets": 0, "searchable": false },
          { "orderable": true, "targets": 1, "searchable": true },
          { "orderable": true, "targets": 2, "searchable": true },
          { "orderable": true, "targets": 3, "searchable": true },
          { "orderable": true, "targets": 4, "searchable": true }
          ]
        } );
        
        $('#student').removeClass( 'display' ).addClass('table table-striped table-bordered');
        $('#student thead th').each( function () {
          
          //Agar kolom Action Tidak Ada Tombol Pencarian
          if( $(this).text() != "Action" ){
            var title = $('#student thead th').eq( $(this).index() ).text();
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
      </div>
          <table id="student"  cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
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
    <div class="modal fade" id="myModals" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Add User</h4>
          </div>
          <div class="modal-body">
            
            <div class="alert alert-danger" role="alert" id="removeWarning">
              <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
              <span class="sr-only">Error:</span>
              Anda yakin ingin menghapus user ini
            </div>
            <br>
            <form class="form-horizontal" id="formAbsen">

              <input type="hidden" class="form-control" id="type" name="type">
              
              <div class="form-group">
                <label for="nis" class="col-sm-2 control-label">NIS</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="nis" name="nis" disabled="yes" >
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
              <div class="form-group">
                <label for="kehadiran" class="col-sm-2 control-label">Kehadiran</label>
                <div class="col-sm-10">
                  <div class="radio-inline">
                    <label>
                      <input type="radio" name="kehadiran" id="kehadiran" value="Tanpa Keterangan" checked>
                      Tanpa Keterangan
                    </label>
                  </div>
                  <div class="radio-inline">
                    <label>
                      <input type="radio" name="kehadiran" id="kehadiran" value="Sakit">
                      Sakit
                    </label>
                  </div>
                  <div class="radio-inline">
                    <label>
                      <input type="radio" name="kehadiran" id="kehadiran" value="Izin">
                      Izin
                    </label>
                  </div>
                </div>
              </div>
            </form>
            
          </div>
          <div class="modal-footer">
            <button type="button" onClick="submitUser()" class="btn btn-default" data-dismiss="modal">Submit</button>
            <button type="button" onclick="clearModals()" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    
    <script>
    
        //Tampilkan Modal 
      function showModalsAbsen( nis )
      {
        waitingDialog.show();
        clearModals();
        
        // Untuk Eksekusi Data Yang Ingin di Edit atau Di Hapus 
        if( nis )
        {
          $.ajax({
            type: "POST",
            url: "assets/crud/crud.php",
            dataType: 'json',
            data: {nis:nis,type:"get"},
            success: function(res) {
              waitingDialog.hide();
              setModalData( res );
            }
          });
        }
        // Untuk Tambahkan Data
        else
        {
          $("#myModals").modal("show");
          $("#myModalLabel").html("New User");
          $("#type").val("new"); 
          waitingDialog.hide();
        }
      }
      
      //Data Yang Ingin Di Tampilkan Pada Modal Ketika Di Edit 
      function setModalData( data )
      {
        $("#myModalLabel").html(data.nama);
        $("#nis").val(data.nis);
        $("#nama").val(data.nama);
        $("#type").val("absen");
        $("#kelas").val(data.kelas);
        $("#telepon").val(data.telepon);
        $("#myModals").modal("show");
      }
      
      //Submit Untuk Eksekusi Tambah/Edit/Hapus Data 
      function submitUser()
      {
        var formData = $("#formAbsen").serialize();
        waitingDialog.show();
        $.ajax({
          type: "POST",
          url: "assets/crud/crud.php",
          dataType: 'json',
          data: formData,
          success: function(data) {
            dTable.ajax.reload(); // Untuk Reload Tables secara otomatis
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
