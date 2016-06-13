
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
        dTable = $('#informasi').DataTable( {
          "bProcessing": true,
          "bServerSide": true,
          "bJQueryUI": false,
          "responsive": true,
          "sAjaxSource": "assets/server/serverSide-informasi.php", // Load Data
          "sServerMethod": "POST",
          "columnDefs": [
          { "orderable": false, "targets": 0, "searchable": false },
          { "orderable": true, "targets": 1, "searchable": true },
          { "orderable": true, "targets": 2, "searchable": true },
          { "orderable": true, "targets": 3, "searchable": true },
          { "orderable": true, "targets": 4, "searchable": true }
          ]
        } );
        
        $('#informasi').removeClass( 'display' ).addClass('table table-striped table-bordered');
        $('#informasi thead th').each( function () {
          
          //Agar kolom Action Tidak Ada Tombol Pencarian
          if( $(this).text() != "Action" ){
            var title = $('#informasi thead th').eq( $(this).index() ).text();
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
          <table id="informasi"  cellpadding="0" cellspacing="0" border="0" class="display" width="100%">
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
    <div class="modal fade" id="modalsInformasi" tabindex="-1" role="dialog" aria-labelledby="modalsInformasiLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="modalsInformasiLabel">Add User</h4>
          </div>
          <div class="modal-body">
            <form class="form-horizontal" id="forminformasi">

              <input type="hidden" class="form-control" id="type3" name="type">
              
              <div class="form-group">
                <label for="nis" class="col-sm-2 control-label">NIS</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="nis3" name="nis">
                </div>
              </div>
              <div class="form-group">
                <label for="nama" class="col-sm-2 control-label">NAMA</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="nama3" name="nama" >
                </div>
              </div>
              <div class="form-group">
                <label for="kelas" class="col-sm-2 control-label">KELAS</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="kelas3" name="kelas" >
                </div>
              </div>
              <div class="form-group">
                <label for="tel" class="col-sm-2 control-label">No. Telepon</label>
                <div class="col-sm-10">
                  <input type="text" class="form-control" id="telepon3" name="telepon" >
                </div>
              </div>
              <div class="form-group">
                <label for="isipesan" class="col-sm-2 control-label">isipesan</label>
                <div class="col-sm-10">
                  <textarea type="text" class="form-control" id="isipesan" name="isipesan"></textarea>
                </div>
              </div>
            </form>
            
          </div>
          <div class="modal-footer">
            <button type="button" onClick="submitInformasi()" class="btn btn-default" data-dismiss="modal">Submit</button>
            <button type="button" onclick="clearModalsInformasi()" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    
    <script>
    
        //Tampilkan Modal 
      function showModalsInformasi( nis )
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
              setModalData4( res );
            }
          });
      }
      
      //Data Yang Ingin Di Tampilkan Pada Modal Ketika Di Edit 
      function setModalData4( data )
      {
        $("#modalsInformasiLabel").html(data.nama);
        $("#nis3").val(data.nis);
        $("#nama3").val(data.nama);
        $("#type3").val("informasi");
        $("#kelas3").val(data.kelas);
        $("#telepon3").val(data.telepon);
        $("#modalsInformasi").modal("show");
      }
      
      //Submit Untuk Eksekusi Tambah/Edit/Hapus Data 
      function submitInformasi()
      {
        var formData = $("#forminformasi").serialize();
        waitingDialog.show();
        $.ajax({
          type: "POST",
          url: "assets/crud/crud.php",
          dataType: 'json',
          data:formData,
          success: function(data) {
            dTable.ajax.reload(); // Untuk Reload Tables secara otomatis
            waitingDialog.hide(); 
          }
        });
      }
      
      
      //Clear Modal atau menutup modal supaya tidak terjadi duplikat modal
      function clearModalsInformasi()
      {
        $("#removeWarning").hide();
        $("#nis3").val("").removeAttr( "disabled" );
        $("#nama3").val("").removeAttr( "disabled" );
        $("#kelas3").val("").removeAttr( "disabled" );
        $("#telepon3").val("").removeAttr( "disabled" );
        $("#isipesan").val("").removeAttr( "disabled" );
        $("#type3").val("");
      }
      
    </script>
        <!-- Akhir Tabel -->
