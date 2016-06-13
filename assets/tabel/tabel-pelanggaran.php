
    <!-- DataTables -->
    <link rel="stylesheet" type="text/css" href="assets/media/css/dataTables.bootstrap.css">
    <link rel="stylesheet" type="text/css" href="assets/media/css/dataTables.responsive.css">
    <script type="text/javascript" language="javascript" src="assets/media/js/jquery.dataTables.js"></script>
    <script type="text/javascript" language="javascript" src="assets/media/js/dataTables.responsive.js"></script>
    <script type="text/javascript" language="javascript" src="assets/media/js/dataTables.bootstrap.js"></script>
    <script type="text/javascript" language="javascript" src="assets/media/js/common.js"></script>
    <script type="text/javascript" language="javascript" >
      
      var dTable;
      // #Example adalah id pada table
      $(document).ready(function() {
        dTable = $('#pelanggaran').DataTable( {
          "bProcessing": true,
          "bServerSide": true,
          "bJQueryUI": false,
          "responsive": true,
          "sAjaxSource": "assets/server/serverSide-pelanggaran.php", // Load Data
          "sServerMethod": "POST",
          "columnDefs": [
          { "orderable": false, "targets": 0, "searchable": false },
          { "orderable": true, "targets": 1, "searchable": true },
          { "orderable": true, "targets": 2, "searchable": true },
          { "orderable": true, "targets": 3, "searchable": true },
          { "orderable": true, "targets": 4, "searchable": true }
          ]
        } );
        
        $('#pelanggaran').removeClass( 'display' ).addClass('table table-striped table-bordered');
        $('#pelanggaran thead th').each( function () {
          
          //Agar kolom Action Tidak Ada Tombol Pencarian
          if( $(this).text() != "Action" ){
            var title = $('#pelanggaran thead th').eq( $(this).index() ).text();
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
          <table id="pelanggaran"  cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
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
    <div class="modal fade" id="ModalsPelanggaran" tabindex="-1" role="dialog" aria-labelledby="ModalLabelPelanggaran" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="ModalLabelPelanggaran">Add User</h4>
          </div>
          <div class="modal-body">
            
            <form class="form-horizontal" id="formPelanggaran">

              <input type="hidden" class="form-control" id="type1" name="type">
              
              <div class="form-group">
                <label for="nis" class="col-sm-2 control-label">NIS</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="nis1" name="nis" disabled="yes">
                </div>
              </div>
              <div class="form-group">
                <label for="nama" class="col-sm-2 control-label">NAMA</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="nama1" name="nama" >
                </div>
              </div>
              <div class="form-group">
                <label for="kelas" class="col-sm-2 control-label">KELAS</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="kelas1" name="kelas" >
                </div>
              </div>
              <div class="form-group">
                <label for="telepon" class="col-sm-2 control-label">No. Telepon</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="telepon1" name="telepon" >
                </div>
              </div>
              <div class="form-group">
                <label for="jenis" class="col-sm-2 control-label">Jenis Pelanggaran</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="jenis" name="jenis" >
                </div>
              </div>
              <div class="form-group">
                <label for="poin" class="col-sm-2 control-label">Poin</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="poin" name="poin" >
                </div>
              </div>
            </form>
            
          </div>
          <div class="modal-footer">
            <button type="button" onClick="submitPelanggaran()" class="btn btn-default" data-dismiss="modal">Submit</button>
            <button type="button" onclick="clearModalsPelanggaran()" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    
    <script>
    
        //Tampilkan Modal 
      function showPelanggaranModals( nis )
      {
        waitingDialog.show();
        clearModalsPelanggaran();
        
        // Untuk Eksekusi Data Yang Ingin di Edit atau Di Hapus 
          $.ajax({
            type: "POST",
            url: "assets/crud/crud.php",
            dataType: 'json',
            data: {nis:nis,type:"get"},
            success: function(res) {
              waitingDialog.hide();
              setPelanggaranModalData( res );
            }
          });
    
       
      }
      
      //Data Yang Ingin Di Tampilkan Pada Modal Ketika Di Edit 
      function setPelanggaranModalData( data )
      {
        $("#ModalLabelPelanggaran").html(data.nama);
        $("#nis1").val(data.nis);
        $("#nama1").val(data.nama);
        $("#type1").val("pelanggaran");
        $("#kelas1").val(data.kelas);
        $("#telepon1").val(data.telepon);
        $("#ModalsPelanggaran").modal("show");
      }
      
      //Submit Untuk Eksekusi Tambah/Edit/Hapus Data 
      function submitPelanggaran()
      {
        var formData = $("#formPelanggaran").serialize();
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
      function clearModalsPelanggaran()
      {
        $("#removeWarning").hide();
        $("#nis1").val("").removeAttr( "disabled" );
        $("#nama1").val("").removeAttr( "disabled" );
        $("#kelas1").val("").removeAttr( "disabled" );
        $("#telepon1").val("").removeAttr( "disabled" );
        $("#type1").val("");
      }
      
    </script>
        <!-- Akhir Tabel -->
