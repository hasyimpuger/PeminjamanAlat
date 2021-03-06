<script type="text/javascript">
		$(document).ready(function(){
			detailPinjam();

			$('#tambahDetail').click(function(){
				$('#myModal').modal('show');
				$('#myModal').find('.modal-title').text('Tambah Alat Yang di Pinjam');
				// autoIdDetailPinjam();
				autoStokAlat();
				$('#myForm').attr('action', '<?php echo base_url('master/Siswa/inputDetail/'); ?>');
			});

			$(document).on('click', '#delDetail', function(e){
				var id_detail = $(this).data('id');
				var id_alat = $(this).data('id-alat');
				var jumlah = $(this).data('jumlah-alat');

				$.ajax({
					url: '<?php echo base_url('master/Siswa/hapusDetail/'); ?>' +id_detail+ '/' +id_alat+ '/' +jumlah,
					dataType: 'json',
					success: function(response){
						if(response.success){
							detailPinjam();
						}else{
							swal('Oops...', 'Error!', 'error');
						}
					},
					error: function(){
						swal('Oops...', 'Something went wrong with ajax !', 'error');
					}
				});
				e.preventDefault();
			});

			$('#saveDetail').click(function(){
				var url = $('#myForm').attr('action');
				var data = $('#myForm').serialize();

				//validasi
				var jumlah = $('input[name=jumlah_detail]');
				var result = '';

				if(jumlah.val()==''){
					jumlah.addClass('is-invalid');
				}else{
					jumlah.removeClass('is-invalid');
					result ='ok';
				}

				if(result=='ok'){
					$.ajax({
						type: 'ajax',
						method: 'post',
						url: url,
						data: data,
						dataType: 'json',
						success: function(response){
							if(response.success){
								$('#myModal').modal('hide');

								detailPinjam();
							}else{
								swal('Oops...', 'Error!', 'error');
							}
						},
						error: function(){
							swal('Oops...', 'Gagal Menambahkan Alat', 'error');
						}
					});
				}
			});

		});

		function detailPinjam(){
			$('#load-detailPinjam').load('<?php echo base_url('master/Siswa/bacaDetail/'); ?>');
		}

		function autoIdDetailPinjam(){
			$.ajax({
				type: 'ajax',
				url: '<?php echo base_url('master/Siswa/autoDetail/'); ?>',
				dataType: 'json',
				success: function(data){
					$('#myModal').find('#idDetail').val(data.kode);
				},
				error: function(){
					alert('Gagal Auto ID');
				}
			});
		}

		function autoStokAlat(){
			$.ajax({
				type: 'ajax',
				url: '<?php echo base_url('master/Siswa/stokAlat/'); ?>',
				dataType: 'json',
				success: function(data){
					var html = '';
					for(var i=0; i<data.length; i++){
						html += '<option value="'+data[i].id_alat+'">'+data[i].nama_alat+' - Stok : '+data[i].stok+'</option>';
					}

					$('#selectStokAlat').html(html);
					/*$('#selectStokAlat').attr('data-provide', 'selectpicker');
					$('#selectStokAlat').attr('data-live-search', 'true');*/
				},
				error: function(){
					alert('Gagal Auto ID Pegawai');
				}
			});
		}
	</script>