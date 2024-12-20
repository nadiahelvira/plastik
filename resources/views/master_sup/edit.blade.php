@extends('layouts.plain')

<style>
    .card {

    }

    .form-control:focus {
        background-color: #E0FFFF !important;
    }

	/* perubahan tab warna di form edit  */
	.nav-item .nav-link.active {
		background-color: red !important; /* Use !important to ensure it overrides */
		color: white !important;
	}

</style>


@section('content')


<div class="content-wrapper">
    <!-- Content Header (Page header) -->

    <!-- /.content-header -->

    <div class="content">
        <div class="container-fluid">
        <div class="row">
            <div class="col-12">
            <div class="card">
                <div class="card-body">

                    <form action="{{($tipx=='new')? url('/sup/store/') : url('/sup/update/'.$header->NO_ID ) }}" method="POST" name ="entri" id="entri" >
  
                        @csrf

						<ul class="nav nav-tabs">
                            <li class="nav-item active">
                                <a class="nav-link active" href="#suppInfo" data-toggle="tab">Main</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#bankInfo" data-toggle="tab">Bank Info</a>
                            </li>
							<!-- <li class="nav-item">
                                <a class="nav-link" href="#deliveryInfo" data-toggle="tab">Lead Delivery Time</a>
                            </li>
							<li class="nav-item">
                                <a class="nav-link" href="#standartInfo" data-toggle="tab">Standart Kualitas</a>
                            </li>
							<li class="nav-item">
                                <a class="nav-link" href="#nilaiInfo" data-toggle="tab">Penilaian</a>
                            </li> -->
                        </ul>
        
                        <div class="tab-content mt-3">
							<!-- style text box model baru -->

							<style>
								/* Ensure specificity with class targeting */
								.form-group.special-input-label {
									position: relative;
									margin-left: 5px ;
								}
						
								/* Ensure only bottom border for input */
								.form-group.special-input-label input {
									width: 100%;
									padding: 10px 0;
									border: none !important;
									border-bottom: 2px solid #ccc !important;
									outline: none !important;
									font-size: 16px !important;
									background: transparent !important; /* Remove any background color */
								}
						
								/* Bottom border color change on focus */
								.form-group.special-input-label input:focus {
									border-bottom: 2px solid #007BFF !important; /* Change color on focus */
								}
						
								/* Style the label with a higher specificity */
								.form-group.special-input-label label {
									position: absolute;
									top: 12px;
									color: #888 !important;
									font-size: 16px !important;
									transition: 0.3s ease all;
									pointer-events: none;
								}
						
								/* Move label above input when focused or has content */
								.form-group.special-input-label input:focus + label,
								.form-group.special-input-label input:not(:placeholder-shown) + label {
									top: -10px !important;
									font-size: 12px !important;
									color: #007BFF !important;
								}
							</style>

							<!-- tutupannya -->

							<div id="suppInfo" class="tab-pane active">	
							
								<div class="form-group row">

										<input type="text" class="form-control NO_ID" id="NO_ID" name="NO_ID"
										placeholder="Masukkan NO_ID" value="{{$header->NO_ID ?? ''}}" hidden readonly>

										<input name="tipx" class="form-control flagz" id="tipx" value="{{$tipx}}" hidden>
								

									<!-- code text box baru -->
									<div class="col-md-3 form-group row special-input-label">

										<input type="text" class="KODES" id="KODES" name="KODES" 
											value="{{$header->KODES}}" placeholder=" " >
										<label for="KODES">Kode</label>
									</div>

									<div class="col-md-1">
									</div>

									<div class="col-md-3 form-group row special-input-label">

										<input type="text" class="NAMAS" id="NAMAS" name="NAMAS" 
											value="{{$header->NAMAS}}" placeholder=" " >
										<label for="NAMAS">Nama</label>
									</div>
									<!-- tutupannya -->

									<div class="col-md-1">
									</div>
									
									<div class="col-md-1">
										<input type="checkbox" class="form-check-input" id="PKP" name="PKP" value="1" {{ ($header->PKP == 1) ? 'checked' : '' }}>
										<label for="PKP">PKP</label>
									</div>			

									<div class="col-md-1" align="right">
										<label for="GOL" class="form-label">Golongan</label>
									</div>
									<div class="col-md-1">
										<select id="GOL" class="form-control"  name="GOL">
											<option value="Y" {{ ($header->GOL == 'Y') ? 'selected' : '' }}>Y</option>
											<option value="Z" {{ ($header->GOL == 'Z') ? 'selected' : '' }}>Z</option>
										</select>
									</div>			
									
									<div class="col-md-1" hidden>
										<input type="checkbox" class="form-check-input" id="AKT" name="AKT" value="1" {{ ($header->AKT == 1) ? 'checked' : '' }}>
										<label for="AKT">AKTIF</label>
									</div>	
								</div>
			
								<div class="form-group row">
									<!-- code text box baru -->
									<div class="col-md-3 form-group row special-input-label">

										<input type="text" class="ALAMAT" id="ALAMAT" name="ALAMAT" 
											value="{{$header->ALAMAT}}" placeholder=" " >
										<label for="ALAMAT">Alamat1</label>
									</div>
									<!-- tutupannya --> 

									<div class="col-md-1">
									</div>

									<!-- code text box baru -->
									<div class="col-md-3 form-group row special-input-label">

										<input type="text" class="ALAMAT2" id="ALAMAT2" name="ALAMAT2" 
											value="{{$header->ALAMAT2}}" placeholder=" " >
										<label for="ALAMAT2">Alamat2</label>
									</div>
									<!-- tutupannya --> 

									<div class="col-md-1">
									</div>

									<!-- code text box baru -->
									<div class="col-md-3 form-group row special-input-label">

										<input type="text" class="KOTA" id="KOTA" name="KOTA" 
											value="{{$header->KOTA}}" placeholder=" " >
										<label for="KOTA">Kota *(Pilih Kota)</label>
									</div>
									<!-- tutupannya --> 

								</div>
			
								<div class="form-group row">

									<!-- code text box baru -->
									<div class="col-md-3 form-group row special-input-label">

										<input type="text" class="KONTAK" id="KONTAK" name="KONTAK" 
											value="{{$header->KONTAK}}" placeholder=" " >
										<label for="KONTAK">Kontak</label>
									</div>
									<!-- tutupannya -->

									<div class="col-md-1">
									</div>

									<!-- code text box baru -->
									<div class="col-md-3 form-group row special-input-label">

										<input type="text" class="TELPON1" id="TELPON1" name="TELPON1" 
											value="{{$header->TELPON1}}" placeholder=" " >
										<label for="TELPON1">Telpon</label>
									</div>
									<!-- tutupannya --> 

									<div class="col-md-1">
									</div>

									<!-- code text box baru -->
									<div class="col-md-3 form-group row special-input-label">

										<input type="text" class="HP" id="HP" name="HP" 
											value="{{$header->HP}}" placeholder=" " >
										<label for="HP">HP</label>
									</div>
									<!-- tutupannya --> 
								</div>

								<div class="form-group row">
									<!-- code text box baru -->
									<div class="col-md-3 form-group row special-input-label">

										<input type="text" class="FAX" id="FAX" name="FAX" 
											value="{{$header->FAX}}" placeholder=" " >
										<label for="FAX">Fax</label>
									</div>
									<!-- tutupannya -->

									<div class="col-md-1">
									</div>

									<!-- code text box baru -->
									<div class="col-md-3 form-group row special-input-label">

										<input type="text" class="EMAOL" id="EMAOL" name="EMAOL" 
											value="{{$header->EMAOL}}" placeholder=" " >
										<label for="EMAOL">Email</label>
									</div>
									<!-- tutupannya -->

									<div class="col-md-1">
									</div>

									<!-- code text box baru -->
									<div class="col-md-3 form-group row special-input-label">

										<input type="text" class="NPWP" id="NPWP" name="NPWP" 
											value="{{$header->NPWP}}" placeholder=" " >
										<label for="NPWP">NPWP</label>
									</div>
									<!-- tutupannya -->
								</div>


								<div class="form-group row">
									<!-- code text box baru -->
									<div class="col-md-3 form-group row special-input-label">

										<input type="text" class="KET" id="KET" name="KET" 
											value="{{$header->KET}}" placeholder=" " >
										<label for="KET">Ket</label>
									</div>
									<!-- tutupannya -->
								</div>
							</div>

							
							<!--------------------------------------------------->
							
							<div id="bankInfo" class="tab-pane">
				
								<div class="form-group row">
									<div class="col-md-1">
										<label for="BANK" class="form-label">Bank</label>
									</div>
									<div class="col-md-2">
										<select name="BANK" id="BANK" class="form-control BANK" style="width: 300px">
											<option value="">--Pilih Bank--</option>
											@foreach($pilihbank as $pilihbankD)
												<option value="{{$pilihbankD->KODE}}" {{ $header->BANK == $pilihbankD->KODE ? 'selected' : '' }}>{{ $pilihbankD->NAMA }}</option>
											@endforeach
										</select>
									</div>     

									<div class="col-md-1">
									</div>   

									<!-- code text box baru -->
									<div class="col-md-3 form-group row special-input-label">

										<input type="text" class="BANK_CAB" id="BANK_CAB" name="BANK_CAB" 
											value="{{$header->BANK_CAB}}" placeholder=" " >
										<label for="BANK_CAB">Cabang</label>
									</div>
									<!-- tutupannya -->	

									<div class="col-md-1">
									</div>

									<!-- code text box baru -->
									<div class="col-md-3 form-group row special-input-label">

										<input type="text" class="BANK_KOTA" id="BANK_KOTA" name="BANK_KOTA" 
											value="{{$header->BANK_KOTA}}" placeholder=" " >
										<label for="BANK_KOTA">Kota</label>
									</div>
									<!-- tutupannya -->     

								</div>
								
								<div class="form-group row">
									<!-- code text box baru -->
									<div class="col-md-3 form-group row special-input-label">

										<input type="text" class="BANK_NAMA" id="BANK_NAMA" name="BANK_NAMA" 
											value="{{$header->BANK_NAMA}}" placeholder=" " >
										<label for="BANK_NAMA">A/N</label>
									</div>
									<!-- tutupannya -->     

									<div class="col-md-1">
									</div>
									
									<!-- code text box baru -->
									<div class="col-md-3 form-group row special-input-label">

										<input type="text" class="BANK_REK" id="BANK_REK" name="BANK_REK" 
											value="{{$header->BANK_REK}}" placeholder=" " >
										<label for="BANK_REK">No.Rekening</label>
									</div>
									<!-- tutupannya -->     

									<div class="col-md-1">
									</div>

									<!-- code text box baru -->
									<div class="col-md-3 form-group row special-input-label">

										<input type="text" class="HARI" id="HARI" name="HARI" 
											value="{{$header->HARI}}" placeholder=" " >
										<label for="HARI">Jatuh Tempo (Hari)</label>
									</div>
									<!-- tutupannya -->
        
								</div>
								
							</div>


							<!---------------------------------------------------------->


							<div id="deliveryInfo" class="tab-pane">	
							
								<div class="form-group row">
									<div class="col-md-1">
										<label for="LDT_NEW" class="form-label">U/ Barang Baru</label>
									</div>

									<div class="col-md-2">
										<input type="text" class="form-control LDT_NEW" id="LDT_NEW" name="LDT_NEW"
										placeholder="" value="{{$header->LDT_NEW}}">
									</div>
									
									<div class="col-md-1">
										<label for="LDT_REP" class="form-label">U/ Barang Repeat</label>
									</div>
									<div class="col-md-2">
										<input type="text" class="form-control LDT_REP" id="LDT_REP" name="LDT_REP"
										placeholder="" value="{{$header->LDT_REP}}">
									</div>
								</div>

								<div class="form-group row">	
									<div class="col-md-1">
										<label for="PLH" class="form-label">Price Lv. High</label>
									</div>
                                    <div class="col-md-2">
                                        <select id="PLH" class="form-control"  name="PLH">
											<option value="1" {{ ($header->PLH == '1') ? 'selected' : '' }}>Aktif</option>
											<option value="0" {{ ($header->PLH == '0') ? 'selected' : '' }}>Tidak Aktif</option>
                                        </select>
                                    </div>

									<div class="col-md-1">
										<label for="PLM" class="form-label">Price Lv. Medium</label>
									</div>
                                    <div class="col-md-2">
                                        <select id="PLM" class="form-control"  name="PLM">
											<option value="1" {{ ($header->PLM == '1') ? 'selected' : '' }}>Aktif</option>
											<option value="0" {{ ($header->PLM == '0') ? 'selected' : '' }}>Tidak Aktif</option>
                                        </select>
                                    </div>

									<div class="col-md-1">
										<label for="PLL" class="form-label">Price Lv. Low</label>
									</div>
									<div class="col-md-2">
										<select id="PLL" class="form-control"  name="PLL">
											<option value="1" {{ ($header->PLL == '1') ? 'selected' : '' }}>Aktif</option>
											<option value="0" {{ ($header->PLL == '0') ? 'selected' : '' }}>Tidak Aktif</option>
										</select>
									</div>
									
								</div>
							</div>


							<!---------------------------------------------------------->


							<div id="standartInfo" class="tab-pane">	
							

								<div class="form-group row">	
									<div class="col-md-1">
										<label for="SKH" class="form-label">Standart Qty High</label>
									</div>
                                    <div class="col-md-2">
                                        <select id="SKH" class="form-control"  name="SKH">
											<option value="1" {{ ($header->SKH == '1') ? 'selected' : '' }}>Aktif</option>
											<option value="0" {{ ($header->SKH == '0') ? 'selected' : '' }}>Tidak Aktif</option>
                                        </select>
                                    </div>

									<div class="col-md-2">
										<input type="text" class="form-control SKH_KET" id="SKH_KET" name="SKH_KET"
										placeholder="" value="{{$header->SKH_KET}}" >
									</div>
								</div>

								<div class="form-group row">

									<div class="col-md-1">
										<label for="SKM" class="form-label">Standart Qty Medium</label>
									</div>
                                    <div class="col-md-2">
                                        <select id="SKM" class="form-control"  name="SKM">
											<option value="1" {{ ($header->SKM == '1') ? 'selected' : '' }}>Aktif</option>
											<option value="0" {{ ($header->SKM == '0') ? 'selected' : '' }}>Tidak Aktif</option>
                                        </select>
                                    </div>

									<div class="col-md-2">
										<input type="text" class="form-control SKM_KET" id="SKM_KET" name="SKM_KET"
										placeholder="" value="{{$header->SKM_KET}}" >
									</div>
								</div>

								<div class="form-group row">	

									<div class="col-md-1">
										<label for="SKL" class="form-label">Standart Qty Low</label>
									</div>
									<div class="col-md-2">
										<select id="SKL" class="form-control"  name="SKL">
											<option value="1" {{ ($header->SKL == '1') ? 'selected' : '' }}>Aktif</option>
											<option value="0" {{ ($header->SKL == '0') ? 'selected' : '' }}>Tidak Aktif</option>
										</select>
									</div>

									<div class="col-md-2">
										<input type="text" class="form-control SKL_KET" id="SKL_KET" name="SKL_KET"
										placeholder="" value="{{$header->SKL_KET}}" >
									</div>
									
								</div>
							</div>


							<!---------------------------------------------------------->


							<div id="nilaiInfo" class="tab-pane">	
							

								<div class="form-group row">	
									<div class="col-md-1">
										<label for="NKUALITAS" class="form-label">Kualitas</label>
									</div>
                                    <div class="col-md-2">
                                        <select id="NKUALITAS" class="form-control"  name="NKUALITAS">
											<option value="" {{ ($header->NKUALITAS == '') ? 'selected' : '' }}>-</option>
											<option value="BAIK" {{ ($header->NKUALITAS == 'BAIK') ? 'selected' : '' }}>Baik</option>
											<option value="CUKUP" {{ ($header->NKUALITAS == 'CUKUP') ? 'selected' : '' }}>Cukup</option>
											<option value="KURANG" {{ ($header->NKUALITAS == 'KURANG') ? 'selected' : '' }}>Kurang</option>
                                        </select>
                                    </div>

									<div class="col-md-2">
										<input type="text" class="form-control KUALITAS" id="KUALITAS" name="KUALITAS"
										placeholder="" value="{{$header->KUALITAS}}" >
									</div>


									<div class="col-md-1">
										<label for="NHARGA" class="form-label">Harga</label>
									</div>
                                    <div class="col-md-2">
                                        <select id="NHARGA" class="form-control"  name="NHARGA">
											<option value="" {{ ($header->NHARGA == '') ? 'selected' : '' }}>-</option>
											<option value="BAIK" {{ ($header->NHARGA == 'BAIK') ? 'selected' : '' }}>Baik</option>
											<option value="CUKUP" {{ ($header->NHARGA == 'CUKUP') ? 'selected' : '' }}>Cukup</option>
											<option value="KURANG" {{ ($header->NHARGA == 'KURANG') ? 'selected' : '' }}>Kurang</option>
                                        </select>
                                    </div>

									<div class="col-md-2">
										<input type="text" class="form-control NOTE_HARGA" id="NOTE_HARGA" name="NOTE_HARGA"
										placeholder="" value="{{$header->NOTE_HARGA}}" >
									</div>
								</div>

								<div class="form-group row">	

									<div class="col-md-1">
										<label for="NPENGIRIMAN" class="form-label">Pengiriman</label>
									</div>
									<div class="col-md-2">
										<select id="NPENGIRIMAN" class="form-control"  name="NPENGIRIMAN">
											<option value="" {{ ($header->NPENGIRIMAN == '') ? 'selected' : '' }}>-</option>
											<option value="BAIK" {{ ($header->NPENGIRIMAN == 'BAIK') ? 'selected' : '' }}>Baik</option>
											<option value="CUKUP" {{ ($header->NPENGIRIMAN == 'CUKUP') ? 'selected' : '' }}>Cukup</option>
											<option value="KURANG" {{ ($header->NPENGIRIMAN == 'KURANG') ? 'selected' : '' }}>Kurang</option>
                                        </select>
									</div>

									<div class="col-md-2">
										<input type="text" class="form-control PENGIRIMAN" id="PENGIRIMAN" name="PENGIRIMAN"
										placeholder="" value="{{$header->PENGIRIMAN}}" >
									</div>

									<div class="col-md-1">
										<label for="NKEAMANAN" class="form-label">Keamanan</label>
									</div>
									<div class="col-md-2">
										<select id="NKEAMANAN" class="form-control"  name="NKEAMANAN">
											<option value="" {{ ($header->NKEAMANAN == '') ? 'selected' : '' }}>-</option>
											<option value="BAIK" {{ ($header->NKEAMANAN == 'BAIK') ? 'selected' : '' }}>Baik</option>
											<option value="CUKUP" {{ ($header->NKEAMANAN == 'CUKUP') ? 'selected' : '' }}>Cukup</option>
											<option value="KURANG" {{ ($header->NKEAMANAN == 'KURANG') ? 'selected' : '' }}>Kurang</option>
                                        </select>
									</div>

									<div class="col-md-2">
										<input type="text" class="form-control KEAMANAN" id="KEAMANAN" name="KEAMANAN"
										placeholder="" value="{{$header->KEAMANAN}}" >
									</div>
									
								</div>

								<div class="form-group row">	

									<div class="col-md-1">
										<label for="NKREDIT" class="form-label">Kredit</label>
									</div>
									<div class="col-md-2">
										<select id="NKREDIT" class="form-control"  name="NKREDIT">
											<option value="" {{ ($header->NKREDIT == '') ? 'selected' : '' }}>-</option>
											<option value="BAIK" {{ ($header->NKREDIT == 'BAIK') ? 'selected' : '' }}>Baik</option>
											<option value="CUKUP" {{ ($header->NKREDIT == 'CUKUP') ? 'selected' : '' }}>Cukup</option>
											<option value="KURANG" {{ ($header->NKREDIT == 'KURANG') ? 'selected' : '' }}>Kurang</option>
                                        </select>
									</div>

									<div class="col-md-2">
										<input type="text" class="form-control KREDIT" id="KREDIT" name="KREDIT"
										placeholder="" value="{{$header->KREDIT}}" >
									</div>

									<div class="col-md-1">
										<label for="NPRODUKSI" class="form-label">Produksi</label>
									</div>
									<div class="col-md-2">
										<select id="NPRODUKSI" class="form-control"  name="NPRODUKSI">
											<option value="" {{ ($header->NPRODUKSI == '') ? 'selected' : '' }}>-</option>
											<option value="BAIK" {{ ($header->NPRODUKSI == 'BAIK') ? 'selected' : '' }}>Baik</option>
											<option value="CUKUP" {{ ($header->NPRODUKSI == 'CUKUP') ? 'selected' : '' }}>Cukup</option>
											<option value="KURANG" {{ ($header->NPRODUKSI == 'KURANG') ? 'selected' : '' }}>Kurang</option>
                                        </select>
									</div>

									<div class="col-md-2">
										<input type="text" class="form-control PRODUKSI" id="PRODUKSI" name="PRODUKSI"
										placeholder="" value="{{$header->PRODUKSI}}" >
									</div>
									
								</div>

								<div class="form-group row">	

									<div class="col-md-1">
										<label for="NPELAYANAN" class="form-label">Pelayanan</label>
									</div>
									<div class="col-md-2">
										<select id="NPELAYANAN" class="form-control"  name="NPELAYANAN">
											<option value="" {{ ($header->NPELAYANAN == '') ? 'selected' : '' }}>-</option>
											<option value="BAIK" {{ ($header->NPELAYANAN == 'BAIK') ? 'selected' : '' }}>Baik</option>
											<option value="CUKUP" {{ ($header->NPELAYANAN == 'CUKUP') ? 'selected' : '' }}>Cukup</option>
											<option value="KURANG" {{ ($header->NPELAYANAN == 'KURANG') ? 'selected' : '' }}>Kurang</option>
										</select>
									</div>

									<div class="col-md-2">
										<input type="text" class="form-control PELAYANAN" id="PELAYANAN" name="PELAYANAN"
										placeholder="" value="{{$header->PELAYANAN}}" >
									</div>

									<div class="col-md-1">
										<label for="NISO" class="form-label">Iso</label>
									</div>
									<div class="col-md-2">
										<select id="NISO" class="form-control"  name="NISO">
											<option value="" {{ ($header->NISO == '') ? 'selected' : '' }}>-</option>
											<option value="BAIK" {{ ($header->NISO == 'BAIK') ? 'selected' : '' }}>Baik</option>
											<option value="CUKUP" {{ ($header->NISO == 'CUKUP') ? 'selected' : '' }}>Cukup</option>
											<option value="KURANG" {{ ($header->NISO == 'KURANG') ? 'selected' : '' }}>Kurang</option>
										</select>
									</div>

									<div class="col-md-2">
										<input type="text" class="form-control ISO" id="ISO" name="ISO"
										placeholder="" value="{{$header->ISO}}" >
									</div>
									
								</div>

								<div class="form-group row">

									<div class="col-md-1">
										<label for="NILAI" class="form-label">Nilai Akhir</label>
									</div>

									<div class="col-md-2">
										<input type="text" class="form-control NILAI" id="NILAI" name="NILAI"
										placeholder="" value="{{$header->NILAI}}" >
									</div>
									
								</div>	
							

								<!--------------------------------------------------->

							</div>

						</div>
        
						<div class="mt-3 col-md-12 form-group row">
							<div class="col-md-4">
								<button type="button" id='TOPX'  onclick="location.href='{{url('/sup/edit/?idx=' .$idx. '&tipx=top')}}'" class="btn btn-outline-primary">Top</button>
								<button type="button" id='PREVX' onclick="location.href='{{url('/sup/edit/?idx='.$header->NO_ID.'&tipx=prev&kodex='.$header->KODES )}}'" class="btn btn-outline-primary">Prev</button>
								<button type="button" id='NEXTX' onclick="location.href='{{url('/sup/edit/?idx='.$header->NO_ID.'&tipx=next&kodex='.$header->KODES )}}'" class="btn btn-outline-primary">Next</button>
								<button type="button" id='BOTTOMX' onclick="location.href='{{url('/sup/edit/?idx=' .$idx. '&tipx=bottom')}}'" class="btn btn-outline-primary">Bottom</button>
							</div>
							<div class="col-md-5">
								<button type="button" id='NEWX' onclick="location.href='{{url('/sup/edit/?idx=0&tipx=new')}}'" class="btn btn-warning">New</button>
								<button type="button" id='EDITX' onclick='hidup()' class="btn btn-secondary">Edit</button>                    
								<button type="button" id='UNDOX' onclick="location.href='{{url('/sup/edit/?idx=' .$idx. '&tipx=undo' )}}'" class="btn btn-info">Undo</button> 
								<button type="button" id='SAVEX' onclick='simpan()' class="btn btn-success" class="fa fa-save"></i>Save</button>

							</div>
							<div class="col-md-3">
								<button type="button" id='HAPUSX' hidden onclick="hapusTrans()" class="btn btn-outline-danger">Hapus</button>
								
								<!-- <button type="button" id='CLOSEX'  onclick="location.href='{{url('/sup' )}}'" class="btn btn-outline-secondary">Close</button> -->

								<!-- tombol close sweet alert -->
								<button type="button" id='CLOSEX' onclick="closeTrans()" class="btn btn-outline-secondary">Close</button></div>
							</div>
						</div>


                    </form>
                </div>
            </div>
            <!-- /.card -->
            </div>
        </div>
        <!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content -->

	<div class="modal fade" id="browseKotaModal" tabindex="-1" role="dialog" aria-labelledby="browseKotaModalLabel" aria-hidden="true">
	 <div class="modal-dialog mw-100 w-75" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="browseKotaModalLabel">Cari Kota</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<table class="table table-stripped table-bordered" id="table-kota">
				<thead>
					<tr>
						<th>Kota</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
		  </div>
		</div>
	  </div>
	</div>

@endsection

@section('footer-scripts')

<script src="{{ asset('js/autoNumerics/autoNumeric.min.js') }}"></script>
<!-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script> -->
<script src="{{asset('foxie_js_css/bootstrap.bundle.min.js')}}"></script>

<!-- tambahan untuk sweetalert -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- tutupannya -->

<script>
    var target;
	var idrow = 1;

    $(document).ready(function () {

		$('body').on('keydown', 'input, select', function(e) {
			if (e.key === "Enter") {
				var self = $(this), form = self.parents('form:eq(0)'), focusable, next;
				focusable = form.find('input,select,textarea').filter(':visible');
				next = focusable.eq(focusable.index(this)+1);
				console.log(next);
				if (next.length) {
					next.focus().select();
				} else {
					// tambah();
					// var nomer = idrow-1;
					// console.log("REC"+nomor);
					// document.getElementById("REC"+nomor).focus();
					// form.submit();
				}
				return false;
			}
		});

 		$tipx = $('#tipx').val();
				
        if ( $tipx == 'new' )
		{
			 baru();			
		}

        if ( $tipx != 'new' )
		{
			 //mati();	
    		 ganti();
		}    

		// $("#TELPON1").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999'});
		// $("#HP").autoNumeric('init', {aSign: '<?php echo ''; ?>',vMin: '-999999999'});
		
    });

//////////////////////////////////////////////////////////////////////////////////////////////////


		//CHOOSE Kota
		var dTableBKota;
		loadDataBKota = function(){
			$.ajax(
			{
				type: 'GET',    
				url: '{{url('kota/browse')}}',

				success: function( response )
				{
			
					resp = response;
					if(dTableBKota){
						dTableBKota.clear();
					}
					for(i=0; i<resp.length; i++){
						
						dTableBKota.row.add([
							'<a href="javascript:void(0);" onclick="chooseKota(\''+resp[i].KOTA+'\')">'+resp[i].KOTA+'</a>',
						]);
					}
					dTableBKota.draw();
				}
			});
		}
		
		dTableBKota = $("#table-kota").DataTable({
			
		});
		
		browseKota = function(){
			loadDataBKota();
			$("#browseKotaModal").modal("show");
		}
		
		chooseKota = function(KOTA){
			$("#KOTA").val(KOTA);
			$("#browseKotaModal").modal("hide");
		}
		
		$("#KOTA").keypress(function(e){

			if(e.keyCode == 46){
				e.preventDefault();
				browseKota();
			}
		}); 
		
		
		//////////////////////////////////////////////////////////////////////////////////////////////////


	function baru() {
		
		 kosong();
		 hidup();
		 
	}
	
	function ganti() {
		
		mati();
		// hidup();
	
	}
	
	
	function batal() {
			
		 mati();
	
	}
	

	function hidup() {

	    $("#TOPX").attr("disabled", true);
	    $("#PREVX").attr("disabled", true);
	    $("#NEXTX").attr("disabled", true);
	    $("#BOTTOMX").attr("disabled", true);

	    $("#NEWX").attr("disabled", true);
	    $("#EDITX").attr("disabled", true);
	    $("#UNDOX").attr("disabled", false);
	    $("#SAVEX").attr("disabled", false);
		
	    $("#HAPUSX").attr("disabled", true);
	    $("#CLOSEX").attr("disabled", false);
		
		
 		$tipx = $('#tipx').val();
		
        if ( $tipx == 'new' )		
		{	
		  	
			$("#KODES").attr("readonly", false);	

		   }
		else
		{
	     	$("#KODES").attr("readonly", true);	

		   }
		   
		$("#PLH").attr("readonly", false);	
		$("#ALAMAT").attr("readonly", false);			
		$("#KOTA").attr("readonly", true);		
		$("#TELPON1").attr("readonly", false);			
		$("#FAX").attr("readonly", false);	
		$("#HP").attr("readonly", false);			
		$("#AKT").attr("readonly", false);		
		$('#KONTAK').attr("readonly", false);

		 $('#EMAIL').attr("readonly", false);	
		 $('#NPWP').attr("readonly", false);	
		 $('#KET').attr("readonly", false);


		 $('#BANK').attr("readonly", false);	
		 $('#BANK_CAB').attr("readonly", false);	
		 $('#BANK_KOTA').attr("readonly", false);	
		 $('#BANK_NAMA').attr("readonly", false);		
		 $('#BANK_REK').attr("readonly", false);
		 $('#HARI').attr("readonly", false);
		 $('#LIM').attr("readonly", false);	
	
	
	}


	function mati() {

	    $("#TOPX").attr("disabled", false);
	    $("#PREVX").attr("disabled", false);
	    $("#NEXTX").attr("disabled", false);
	    $("#BOTTOMX").attr("disabled", false);

	    $("#NEWX").attr("disabled", false);
	    $("#EDITX").attr("disabled", false);
	    $("#UNDOX").attr("disabled", true);
	    $("#SAVEX").attr("disabled", true);
	    $("#HAPUSX").attr("disabled", false);
	    $("#CLOSEX").attr("disabled", false);
		
		$("#KODES").attr("readonly", true);			
		$("#PLH").attr("readonly", true);	
		$("#ALAMAT").attr("readonly", true);			
		$("#KOTA").attr("readonly", true);		
		$("#TELPON1").attr("readonly", true);			
		$("#FAX").attr("readonly", true);	
		$("#HP").attr("readonly", true);			
		$("#AKT").attr("readonly", true);		
		$('#KONTAK').attr("readonly", true);

		 $('#EMAIL').attr("readonly", true);	
		 $('#NPWP').attr("readonly", true);	
		 $('#KET').attr("readonly", true);


		 $('#BANK').attr("readonly", true);	
		 $('#BANK_CAB').attr("readonly", true);	
		 $('#BANK_KOTA').attr("readonly", true);	
		 $('#BANK_NAMA').attr("readonly", true);		
		 $('#BANK_REK').attr("readonly", true);
		 $('#HARI').attr("readonly", true);
		 $('#LIM').attr("readonly", true);	
		
		
	

		
	}


	function kosong() {
				
		 $('#KODES').val("");	
		 $('#NAMAS').val("");	
		 $('#ALAMAT').val("");	
		 $('#KOTA').val("");		

		 $('#TELPON1').val("");	
		 $('#FAX').val("");	
		 $('#HP').val("");	
		 $('#AKT').val("0");		
		 $('#KONTAK').val("");

		 $('#EMAIL').val("");	
		 $('#NPWP').val("");	
		 $('#KET').val("");	


		 $('#BANK').val("");	
		 $('#BANK_CAB').val("");	
		 $('#BANK_KOTA').val("");	
		 $('#BANK_NAMA').val("");		
		 $('#BANK_REK').val("");
		 $('#HARI').val("0");
		 $('#LIM').val("0");		


		 
	}
	
	function hapusTrans() {
    }

	
	function hapusTransx() {
		let text = "Hapus Transaksi "+$('#NO_BUKTI').val()+"?";

		var loc ='';
		
		Swal.fire({
			title: 'Are you sure?',
			text: text,
			icon: 'warning',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			confirmButtonText: 'Yes, delete it!',
			cancelButtonText: 'Cancel'
		}).then((result) => {
			if (result.isConfirmed) {
				// Show a success message before redirecting to delete the data
				Swal.fire({
					title: 'Deleted!',
					text: 'Data has been deleted.',
					icon: 'success',
					confirmButtonText: 'OK'
				}).then(() => {
					// Redirect to delete the data after user confirms the success message
	            	loc = "{{ url('/sup/delete/'.$header->NO_ID) }}"  ;

		            // alert(loc);
	            	window.location = loc;
		
				});
			}
		});
	}
	
	function closeTrans() {
		console.log("masuk");
		var loc ='';
		
		Swal.fire({
			title: 'Are you sure?',
			text: 'Do you really want to close this page? Unsaved changes will be lost.',
			icon: 'warning',
			showCancelButton: true,
			confirmButtonText: 'Yes, close it',
			cancelButtonText: 'No, stay here'
		}).then((result) => {
			if (result.isConfirmed) {
	        	loc = "{{ url('/sup/') }}" ;
				window.location = loc ;
			} else {
				Swal.fire({
					icon: 'info',
					title: 'Cancelled',
					text: 'You stayed on the page'
				});
			}
		});
	}

	// tutupannya

	function CariBukti() {
		
		var cari = $("#CARI").val();
		var loc = "{{ url('/sup/edit/') }}" + '?idx={{ $header->NO_ID}}&tipx=search&kodex=' +encodeURIComponent(cari);
		window.location = loc;
		
	}

     
     
    var hasilCek;
	function cekSup(kodes) {
		$.ajax({
			type: "GET",
			url: "{{url('sup/ceksup')}}",
            async: false,
			data: ({ KODES: kodes, }),
			success: function(data) {
                if (data.length > 0) {
                    $.each(data, function(i, item) {
                        hasilCek=data[i].ADA;
                    });
                }
			},
			error: function() {
				alert('Error cekSup occured');
			}
		});
		return hasilCek;
	}
    
	function simpan() {
        hasilCek=0;
		$tipx = $('#tipx').val();
				
        if ( $tipx == 'new' )
		{
			cekSup($('#KODES').val());		
		}
		

        (hasilCek==0) ? document.getElementById("entri").submit() : alert('Suplier '+$('#KODES').val()+' sudah ada!');
	}
</script>
@endsection

