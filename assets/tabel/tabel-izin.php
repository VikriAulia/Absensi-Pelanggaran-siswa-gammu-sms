
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
        dTable = $('#izin').DataTable( {
          "bProcessing": true,
          "bServerSide": true,
          "bJQueryUI": false,
          "responsive": true,
          "sAjaxSource": "assets/server/serverSide-izin.php", // Load Data
          "sServerMethod": "POST",
          "columnDefs": [
          { "orderable": false, "targets": 0, "searchable": false },
          { "orderable": true, "targets": 1, "searchable": true },
          { "orderable": true, "targets": 2, "searchable": true },
          { "orderable": true, "targets": 3, "searchable": true },
          { "orderable": true, "targets": 4, "searchable": true }
          ]
        } );
        
        $('#izin').removeClass( 'display' ).addClass('table table-striped table-bordered');
        $('#izin thead th').each( function () {
          
          //Agar kolom Action Tidak Ada Tombol Pencarian
          if( $(this).text() != "Action" ){
            var title = $('#izin thead th').eq( $(this).index() ).text();
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
          <table id="izin"  cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
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
    <div class="modal fade" id="ModalsIzin" tabindex="-1" role="dialog" aria-labelledby="ModalLabelIzin" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="ModalLabelIzin">Add User</h4>
          </div>
          <div class="modal-body">
            
            <form class="form-horizontal" id="formizin">

              <input type="hidden" class="form-control" id="type2" name="type">              
              <div class="form-group">
                <label for="nis" class="col-sm-2 control-label">NIS</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="nis2" name="nis" >
                </div>
              </div>
              <div class="form-group">
                <label for="nama" class="col-sm-2 control-label">NAMA</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="nama2" name="nama" >
                </div>
              </div>
              <div class="form-group">
                <label for="kelas" class="col-sm-2 control-label">KELAS</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="kelas2" name="kelas" >
                </div>
              </div>
              <div class="form-group">
                <label for="telepon" class="col-sm-2 control-label">No. Telepon</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="telepon2" name="telepon" >
                </div>
              </div>
              <div class="form-group">
                <label for="alasan" class="col-sm-2 control-label">Alasan</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="alasan" name="alasan" >
                </div>
              </div>
            </form>
            
          </div>
          <div class="modal-footer">
            <button type="button" onClick="submitIzin()" class="btn btn-default" data-dismiss="modal">Submit</button>
            <button type="button" onclick="clearModalsIzin()" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    
    <script>
    
        //Tampilkan Modal 
      function showModalsIzin( nis )
      {
        waitingDialog.show();
        clearModals();
        
        // Untuk Eksekusi Data Yang Ingin di Edit atau Di Hapus 
          $.ajax({
            type: "POST",
            url: "assets/crud/crud.php",
            dataType: 'json',
            data: {nis:nis,type:"get"},
            success: function(res) {
              waitingDialog.hide();
              setModalDataIzin( res );
            }
          });
      }
      
      //Data Yang Ingin Di Tampilkan Pada Modal Ketika Di Edit 
      function setModalDataIzin( data )
      {
        $("#ModalLabelIzin").html(data.nama);
        $("#nis2").val(data.nis);
        $("#nama2").val(data.nama);
        $("#type2").val("izin");
        $("#kelas2").val(data.kelas);
        $("#telepon2").val(data.telepon);
        $("#ModalsIzin").modal("show");
      }
      
      //Submit Untuk Eksekusi Tambah/Edit/Hapus Data 
      function submitIzin()
      {
        var formData = $("#formizin").serialize();
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
      function clearModalsIzin()
      {
        $("#removeWarning").hide();
        $("#nis2").val("").removeAttr( "disabled" );
        $("#nama2").val("").removeAttr( "disabled" );
        $("#kelas2").val("").removeAttr( "disabled" );
        $("#telepon2").val("").removeAttr( "disabled" );
        $("#alasan").val("").removeAttr( "disabled" );
        $("#type2").val("");
      }
      
    </script>
        <!-- Akhir Tabel -->
