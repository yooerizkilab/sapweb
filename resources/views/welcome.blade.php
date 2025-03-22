<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .custom-table {
            width: 100%;
            border-collapse: collapse;
        }

        .custom-table td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
        }

        .text-red {
            color: red;
        }

        .text-center {
            text-align: center;
        }

        .text-end {
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="container mt-4 mb-4">
        <div class="card shadow">
            <!-- Header -->
            <div class="card-header text-white text-center py-3" style="background-color: #0095da;">
                <h4 class="m-0">PT. UTOMO DECK METAL WORKS - GROUP</h4>
                <h5 class="m-0">KALKULATOR HITUNG HARGA ATAP (PROYEK)</h5>
            </div>

            <div class="card-body">
                <table class="table table-borderless">
                    <tbody>
                        <!-- Purpose -->
                        <tr class="table-secondary">
                            <th width="50%">Purpose</th>
                            <th class="text-end text-danger">Proyek</th>
                        </tr>

                        <!-- Profil -->
                        <tr>
                            <td>Profil</td>
                            <td>
                                <select name="profile" class="form-control text-danger" id="profile">
                                    <option value="" disabled selected>Choose Profil</option>
                                    <option value="1">Profil 1</option>
                                    <option value="2">Profil 2</option>
                                </select>
                            </td>
                        </tr>

                        <!-- Material -->
                        <tr>
                            <td>Material</td>
                            <td>
                                <select name="material" class="form-control text-danger" id="material">
                                    <option value="" disabled selected>Choose Material</option>
                                    <option value="1">Material 1</option>
                                    <option value="2">Material 2</option>
                                </select>
                            </td>
                        </tr>

                        <!-- AZ/Z/AA (Nilai) -->
                        <tr>
                            <td>AZ/Z/AA (Nilai)</td>
                            <td>
                                <input type="number" class="form-control text-danger" name="nilai" id="nilai">
                            </td>
                        </tr>

                        <!-- Warna -->
                        <tr>
                            <td>Warna</td>
                            <td>
                                <select name="warna" class="form-control text-danger" id="warna">
                                    <option value="" disabled selected>Choose Warna</option>
                                    <option value="1">Warna 1</option>
                                    <option value="2">Warna 2</option>
                                </select>
                            </td>
                        </tr>

                        <!-- Lebar Bahan Coil -->
                        <tr>
                            <td>Lebar Bahan Coil</td>
                            <td>
                                <input type="number" class="form-control text-primary" name="lebar_coil"
                                    id="lebar_coil">
                            </td>
                        </tr>

                        <!-- Tebal -->
                        <tr>
                            <td>Tebal</td>
                            <td>
                                <div class="row">
                                    <div class="col-6">
                                        <span class="text-dark">TCT</span>
                                    </div>
                                    <div class="col-6">
                                        <input type="number" class="form-control text-danger text-end" name="tebal"
                                            id="tebal">
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- Lebar Bahan Profil -->
                        <tr>
                            <td>Lebar Bahan Profil</td>
                            <td class="text-end">
                                <strong class="text-primary text-end" id="lebar_profil">1.219</strong>
                            </td>
                        </tr>

                        <!-- AZ/Z/AA/SS -->
                        <tr>
                            <td>AZ/Z/AA/SS</td>
                            <td>
                                <select name="az" class="form-control text-danger" id="az">
                                    <option value="" disabled selected>Choose AZ/Z/AA/SS</option>
                                    <option value="1">AZ</option>
                                    <option value="2">Z</option>
                                    <option value="3">AA</option>
                                    <option value="4">SS</option>
                                </select>
                            </td>
                        </tr>

                        <!-- Lebar Efektif Produk -->
                        <tr>
                            <td>Lebar Efektif Produk</td>
                            <td class="text-end">
                                <strong class="text-primary" id="lebar_efektif">890.000</strong>
                            </td>
                        </tr>

                        <!-- SKU -->
                        <tr>
                            <td>SKU</td>
                            <td>
                                <textarea class="form-control text-primary" rows="2" id="sku" readonly>Sengalume Natural 0.5 BMT X 1219MM AZ150 G550</textarea>
                            </td>
                        </tr>

                        <!-- Group (BMT) -->
                        <tr>
                            <td>Group (bmt)</td>
                            <td>
                                <textarea class="form-control text-primary" rows="2" id="group" readonly>Sengalume Tebal TCT 0.50 AZ 150 Lebar 1219 mm Natural Proyek</textarea>
                            </td>
                        </tr>

                        <!-- Density -->
                        <tr>
                            <td>Density</td>
                            <td class="text-end">
                                <strong class="text-primary" id="density">0.49</strong>
                            </td>
                        </tr>

                        <tr>
                            <td></td>
                            <td>
                                <div class="row">
                                    <div class="col-6">
                                        <span class="text-dark">BMT</span>
                                    </div>
                                    <div class="col-6 text-end">
                                        <strong class="text-primary" id="bmt">0.45</strong>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- Harga Bahan Baku -->
                        <tr>
                            <td>Harga Bahan Baku</td>
                            <td>
                                <div class="row">
                                    <div class="col-6">
                                        <span class="text-dark">/KG</span>
                                    </div>
                                    <div class="col-6 text-end">
                                        <strong class="text-primary" id="harga_bahan_baku">15.123</strong>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>G300/G500</td>
                        </tr>

                        <!-- Volume Kebutuhan -->
                        <tr>
                            <td>Volume Kebutuhan (KG)</td>
                            <td>
                                <div class="row">
                                    <div class="col-6">
                                        <span class="text-dark text-center" id="volume_kebutuhan">235.326,2</span>
                                    </div>
                                    <div class="col-6 text-start">
                                        <strong class="text-primary">Kg/m2</strong>
                                    </div>
                                </div>
                            </td>
                        </tr>


                        <!-- Biaya Potong -->
                        <tr>
                            <td>Biaya Potong</td>
                            <td>
                                <div class="row">
                                    <div class="col-4">
                                        <span class="text-dark" id="biaya_potong">0</span>
                                    </div>
                                    <div class="col-4 text-end">
                                        <strong class="text-primary">Potong</strong>
                                    </div>
                                    <div class="col-4 text-end">
                                        <strong class="text-primary" id="harga_potong">-</strong>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- Biaya Tambah Potong -->
                        <tr>
                            <td>Biaya Tambah Potong</td>
                            <td class="text-end">
                                <strong class="text-primary" id="biaya_tambah_potong"> - </strong>
                            </td>
                        </tr>

                        <!-- Biaya Selongsong -->
                        <tr>
                            <td>Biaya Selongsong</td>
                            <td class="text-end">
                                <strong class="text-primary" id="biaya_selongsong"> - </strong>
                            </td>
                        </tr>

                        <!-- Biaya Ongkir -->
                        <tr>
                            <td>Biaya Ongkir</td>
                            <td>
                                <div class="row">
                                    <div class="col-6">
                                        <select name="ongkir" id="ongkir" class="form-control">
                                            <option value="" selected disabled>Choose Ongkir</option>
                                            <option value="0">Tidak</option>
                                            <option value="1">Ya</option>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <strong class="text-primary" id="harga_ongkir">-</strong>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- Diskon -->
                        <tr>
                            <td>Diskon</td>
                        </tr>

                        <!-- Biaya Kirim -->
                        <tr>
                            <td>Potongan Biaya Pengiriman</td>
                            <td>
                                <select name="biaya_kirim" class="form-control text-danger" id="biaya_kirim">
                                    <option value="" disabled selected>Choose Biaya Kirim</option>
                                    <option value="0">Tidak</option>
                                    <option value="1">Ya</option>
                                </select>
                            </td>
                        </tr>

                        <!-- Lokasi Pabrik & Lokasi Gudang -->
                        <tr>
                            <td>
                                <select name="lokasi" id="lokasi" class="form-control text-danger">
                                    <option value="" disabled selected>Choose Lokasi</option>
                                    <option value="1">Jakarta</option>
                                    <option value="2">Bandung</option>
                                </select>
                            </td>
                            <td>
                                <div class="row">
                                    <div class="col-6">
                                        <select name="warehouse" id="warehouse" class="form-control text-danger">
                                            <option value="" disabled selected>Choose Warehouse</option>
                                            <option value="1">Jakarta</option>
                                            <option value="2">Bandung</option>
                                        </select>
                                    </div>
                                    <div class="col-6 text-end">
                                        <strong class="text-primary" id="harga_kirim">Rp. 260,00</strong>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td class="text-center">
                                <strong class="text-primary">Lokasi - Lokasi</strong>
                            </td>
                            <td>
                                <div class="row">
                                    <div class="col-6 text-center">
                                        <strong class="text-primary">KG</strong>
                                    </div>
                                    <div class="col-6 text-end">
                                        <strong class="text-primary" id="total_harga_kirim">Rp . 260,00</strong>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- HPP Bahan Baku -->
                        <tr>
                            <td class="bg-success">
                                <strong class="text-dark">HPP Bahan Baku (/m2)</strong>
                            </td>
                            <td class="text-end bg-success">
                                <strong class="text-dark" id="hpp_bahan_baku">Rp. 76.277.00</strong>
                            </td>
                        </tr>

                        <!--  -->
                        <tr>
                            <td>Konektor, Aksesoris, dan Upah Pabrikasi</td>
                            <td>
                                <div class="row">
                                    <div class="col-4">
                                        <select name="aksesoris" id="aksesoris" class="form-control">
                                            <option value="" selected disabled>Choose Aksesoris</option>
                                            <option value="1">A</option>
                                            <option value="2">B</option>
                                            <option value="3">C</option>
                                        </select>
                                    </div>
                                    <div class="col-4">
                                        <select name="pakai" id="pakai" class="form-control">
                                            <option value="" selected disabled>Choose Used</option>
                                            <option value="1">Ya</option>
                                            <option value="0">Tidak</option>
                                        </select>
                                    </div>
                                    <div class="col-4 text-end">
                                        <strong class="text-primary" id="harga_aksesoris">Rp 10.822,40</strong>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- Type Prof -->
                        <tr>
                            <td>Type Profil</td>
                            <td>
                                <div class="row">
                                    <div class="col-4">
                                        <select name="type_profil" id="type_profil" class="form-control">
                                            <option value="" selected disabled>Choose Ongkir</option>
                                            <option value="0">Stantdart</option>
                                            <option value="1">Radial</option>
                                            <option value="2">Crimping</option>
                                            <option value="3">Batik</option>
                                        </select>
                                    </div>
                                    <div class="col-4">
                                        <select name="pakai" id="pakai" class="form-control">
                                            <option value="" selected disabled>Choose Used</option>
                                            <option value="1">Ya</option>
                                            <option value="0">Tidak</option>
                                        </select>
                                    </div>
                                    <div class="col-4 text-end">
                                        <strong class="text-primary" id="harga_type_profil">-</strong>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td class="bg-success">
                                <strong class="text-dark">HPP Aksesoris (M2)</strong>
                            </td>
                            <td class="text-end bg-success">
                                <strong class="text-dark" id="hpp_aksesoris">Rp. 10.822.40</strong>
                            </td>
                        </tr>

                        <tr>
                            <td>Upah Pasang</td>
                            <td>
                                <div class="row">
                                    <div class="col-4">
                                        <select name="profile_item" id="profile_item" class="form-control">
                                            <option value="" selected disabled>Choose Ongkir</option>
                                            <option value=""> UDS (UTOMO DOUBLE SEAM)</option>
                                            <option value="">U960 (Superklik)</option>
                                        </select>
                                    </div>
                                    <div class="col-4">
                                        <select name="pakai" id="pakai" class="form-control">
                                            <option value="" selected disabled>Choose Used</option>
                                            <option value="1">Ya</option>
                                            <option value="0">Tidak</option>
                                        </select>
                                    </div>
                                    <div class="col-4 text-end">
                                        <strong class="text-primary" id="harga_upah_pasang">Rp. 17.070.00</strong>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Area Kerja</td>
                            <td>
                                <select name="area" id="area" class="form-control">
                                    <option value="" selected disabled>Choose Area</option>
                                    <option value="1">Area 1</option>
                                    <option value="2">Area 2</option>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td class="bg-success">
                                <strong class="text-dark">HPP Upah Pasang (M2)</strong>
                            </td>
                            <td class="text-end bg-success">
                                <strong class="text-dark" id="hpp_upah_pasang">Rp. 17.070.00</strong>
                            </td>
                        </tr>

                        <!-- Operasional -->
                        <tr>
                            <td><strong class="text-primary">Operasional</strong></td>
                        </tr>

                        <tr>
                            <td>Biaya Produksi</td>
                            <td>
                                <div class="row">
                                    <div class="col-4 text-center">
                                        <span class="text-dark" id="biaya_produksi">Rp. 2.464,51</span>
                                    </div>
                                    <div class="col-4">
                                        <select name="pakai_biaya_produksi" id="pakai_biaya_produksi"
                                            class="form-control">
                                            <option value="" selected disabled>Choose Type</option>
                                            <option value="0">Tidak</option>
                                            <option value="1">Ya</option>
                                        </select>
                                    </div>
                                    <div class="col-4 text-end">
                                        <strong class="text-primary" id="total_biaya_produksi">Rp. 2.464,51</strong>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- Onchange yes biaya produksi -->
                        <tr>
                            <td class="ps-4">Alokasi Depresiasi Mesin</td>
                            <td>
                                <div class="row">
                                    <div class="col-6 text-center">
                                        <span class="text-dark" id="alokasi_mesin">Rp. - </span>
                                    </div>
                                    <div class="col-6 text-end">
                                        <strong class="text-primary" id="total_alokasi_mesin">Rp. - </strong>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="ps-4">Biaya Power / Listrik</td>
                            <td>
                                <div class="row">
                                    <div class="col-6 text-center">
                                        <span class="text-dark" id="biaya_power">Rp.177,53</span>
                                    </div>
                                    <div class="col-6 text-end">
                                        <strong class="text-primary" id="total_biaya_power">Rp. - </strong>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="ps-4">Biaya Maintenance Mesin</td>
                            <td>
                                <div class="row">
                                    <div class="col-6 text-center">
                                        <span class="text-dark" id="biaya_maintenance">Rp.19.44</span>
                                    </div>
                                    <div class="col-6 text-end">
                                        <strong class="text-primary" id="total_biaya_maintenance">Rp. - </strong>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="ps-4">Biaya Tenaga Kerja Langsung</td>
                            <td>
                                <div class="row">
                                    <div class="col-6 text-center">
                                        <span class="text-dark" id="biaya_tenaga_kerja">Rp.583.33</span>
                                    </div>
                                    <div class="col-6 text-end">
                                        <strong class="text-primary" id="total_biaya_tenaga_kerja">Rp. - </strong>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="ps-4">Biaya Overhead Pabrik</td>
                            <td>
                                <div class="row">
                                    <div class="col-6 text-center">
                                        <span class="text-dark" id="biaya_overhead">Rp.964.48</span>
                                    </div>
                                    <div class="col-6 text-end">
                                        <strong class="text-primary" id="total_biaya_overhead">Rp. - </strong>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="ps-4">Biaya Handling</td>
                            <td>
                                <div class="row">
                                    <div class="col-6 text-center">
                                        <span class="text-dark" id="biaya_handling">Rp.63.90</span>
                                    </div>
                                    <div class="col-6 text-end">
                                        <strong class="text-primary" id="total_biaya_handling">Rp. - </strong>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="ps-4">Biaya Packing (1.219 x 50m')</td>
                            <td>
                                <div class="row">
                                    <div class="col-6 text-center">
                                        <span class="text-dark" id="biaya_packing">Rp.100.27</span>
                                    </div>
                                    <div class="col-6 text-end">
                                        <strong class="text-primary" id="total_biaya_packing">Rp. - </strong>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="ps-4">Depresiasi Gedung</td>
                            <td>
                                <div class="row">
                                    <div class="col-6 text-center">
                                        <span class="text-dark" id="depresiasi_gedung">Rp.555.56</span>
                                    </div>
                                    <div class="col-6 text-end">
                                        <strong class="text-primary" id="total_depresiasi_gedung">Rp. - </strong>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Umum Admin Dll</td>
                            <td>
                                <div class="row">
                                    <div class="col-4 text-center">
                                        <span class="text-dark" id="umum_admin_dll">Rp. 471.37</span>
                                    </div>
                                    <div class="col-4">
                                        <select name="pakai_umum" id="pakai_umum" class="form-control">
                                            <option value="" selected disabled>Choose Type</option>
                                        </select>
                                    </div>
                                    <div class="col-4 text-end">
                                        <strong class="text-primary" id="total_umum_admin_dll">Rp. 471.37</strong>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <!-- Onchange yes Umum Admin  -->
                        <tr>
                            <td class="ps-4">Biaya Penjualan</td>
                            <td>
                                <div class="row">
                                    <div class="col-6 text-center">
                                        <span class="text-dark" id="biaya_penjualan">Rp. 462.96</span>
                                    </div>
                                    <div class="col-6 text-end">
                                        <strong class="text-primary" id="total_biaya_penjualan">Rp. - </strong>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="ps-4">Biaya Asuransi AR & Piutang</td>
                            <td>
                                <div class="row">
                                    <div class="col-6 text-center">
                                        <span class="text-dark" id="biaya_asuransi">Rp 0.04</span>
                                    </div>
                                    <div class="col-6 text-end">
                                        <strong class="text-primary" id="total_biaya_asuransi">Rp. - </strong>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="ps-4">Biaya Transportasi Penjualan</td>
                            <td>
                                <div class="row">
                                    <div class="col-6 text-center">
                                        <span class="text-dark" id="biaya_transportasi">Rp.7.94</span>
                                    </div>
                                    <div class="col-6 text-end">
                                        <strong class="text-primary" id="total_biaya_transportasi">Rp. - </strong>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="ps-4">Biaya Bunga (Cost Of Money)</td>
                            <td>
                                <div class="row">
                                    <div class="col-6 text-center">
                                        <span class="text-dark" id="biaya_bunga">Rp.0.44</span>
                                    </div>
                                    <div class="col-6 text-end">
                                        <strong class="text-primary" id="total_biaya_bunga">Rp. - </strong>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Overhead Project</td>
                            <td>
                                <div class="row">
                                    <div class="col-4 text-center">
                                        <span class="text-dark" id="overhead_project">Rp. 348.74</span>
                                    </div>
                                    <div class="col-4">
                                        <select name="pakai_overhead" id="pakai_overhead" class="form-control">
                                            <option value="" selected disabled>Choose</option>
                                            <option value="0">Tidak</option>
                                            <option value="1">Iya</option>
                                        </select>
                                    </div>
                                    <div class="col-4 text-end">
                                        <strong class="text-primary" id="total_overhead_project">Rp. 348.74</strong>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Asset</td>
                            <td>
                                <div class="row">
                                    <div class="col-4 text-center">
                                        <span class="text-dark" id="asset">Rp. 84.52</span>
                                    </div>
                                    <div class="col-4">
                                        <select name="pakai_asset" id="pakai_asset" class="form-control">
                                            <option value="" selected disabled>Choose</option>
                                            <option value="0">Tidak</option>
                                            <option value="1">Iya</option>
                                        </select>
                                    </div>
                                    <div class="col-4 text-end">
                                        <strong class="text-primary" id="total_asset">Rp. 84.52</strong>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Biaya Asuransi</td>
                            <td>
                                <div class="row">
                                    <div class="col-4 text-center">
                                        <span class="text-dark" id="biaya_asuransi">Rp. 504.05</span>
                                    </div>
                                    <div class="col-4">
                                        <select name="pakai_biaya_asuransi" id="pakai_biaya_asuransi"
                                            class="form-control">
                                            <option value="" selected disabled>Choose</option>
                                            <option value="0">Tidak</option>
                                            <option value="1">Iya</option>
                                        </select>
                                    </div>
                                    <div class="col-4 text-end">
                                        <strong class="text-primary" id="total_biaya_asuransi">Rp. 504.05</strong>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Biaya HSE Specialis</td>
                            <td>
                                <div class="row">
                                    <div class="col-4 text-center">
                                        <span class="text-dark" id="biaya_hse_specialis">Rp. 555.56</span>
                                    </div>
                                    <div class="col-4">
                                        <select name="pakai_biaya_hse_specialis" id="pakai_biaya_hse_specialis"
                                            class="form-control">
                                            <option value="" selected disabled>Choose</option>
                                            <option value="0">Tidak</option>
                                            <option value="1">Iya</option>
                                        </select>
                                    </div>
                                    <div class="col-4 text-end">
                                        <strong class="text-primary" id="total_biaya_hse_specialis">Rp. -</strong>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Biaya Mod-Demob Alat</td>
                            <td>
                                <div class="row">
                                    <div class="col-4 text-center" id="biaya_mod_demob_alat">
                                        <span class="text-dark">Rp. 43.380.000.00</span>
                                    </div>
                                    <div class="col-4">
                                        <select name="pakai_biaya_mod_demob_alat" id="pakai_biaya_mod_demob_alat"
                                            class="form-control">
                                            <option value="" selected disabled>Choose</option>
                                            <option value="0">Tidak</option>
                                            <option value="1">Iya</option>
                                        </select>
                                    </div>
                                    <div class="col-4 text-end">
                                        <strong class="text-primary" id="total_biaya_mod_demob_alat">Rp. -</strong>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td class="ps-4 bg-warning">
                                <input type="number" class="form-control text-danger" name="jarak"
                                    id="jarak">
                            </td>
                            <td class="bg-warning">
                                <select name="kendaraan" id="kendaraan" class="form-control">
                                    <option value="" selected disabled>Choose</option>
                                    <option value="1">Truck</option>
                                    <option value="1">Truck</option>
                                    <option value="1">Truck</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="ps-4">Reet* Armada</td>
                            <td><span class="text-dark" id="reet_armada">4.00</span></td>
                        </tr>

                        <tr>
                            <td>Mobsys</td>
                            <td>
                                <div class="row">
                                    <div class="col-4 text-center">
                                        <span class="text-dark" id="mobsys">Rp. 1.286.53</span>
                                    </div>
                                    <div class="col-4">
                                        <select name="pakai_mobsys" id="pakai_mobsys" class="form-control">
                                            <option value="" selected disabled>Choose</option>
                                            <option value="0">Tidak</option>
                                            <option value="1">Iya</option>
                                        </select>
                                    </div>
                                    <div class="col-4 text-end">
                                        <strong class="text-primary" id="total_mobsys">Rp. -</strong>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Biaya Roll on Site</td>
                            <td>
                                <div class="row">
                                    <div class="col-4 text-center">
                                        <span class="text-dark" id="biaya_roll_on_site">Rp. 883.00</span>
                                    </div>
                                    <div class="col-4">
                                        <select name="pakai_biaya_roll_on_site" id="pakai_biaya_roll_on_site"
                                            class="form-control">
                                            <option value="" selected disabled>Choose</option>
                                            <option value="0">Tidak</option>
                                            <option value="1">Iya</option>
                                        </select>
                                    </div>
                                    <div class="col-4 text-end">
                                        <strong class="text-primary" id="total_biaya_roll_on_site">Rp. -</strong>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Kirim Coil</td>
                            <td>
                                <div class="row">
                                    <div class="col-4 text-center">
                                        <span class="text-dark" id="kirim_coil">Rp. 36.812.500</span>
                                    </div>
                                    <div class="col-4">
                                        <select name="pakai_kirim_coil" id="pakai_kirim_coil" class="form-control">
                                            <option value="" selected disabled>Choose</option>
                                            <option value="0">Tidak</option>
                                            <option value="1">Iya</option>
                                        </select>
                                    </div>
                                    <div class="col-4 text-end">
                                        <strong class="text-primary" id="total_kirim_coil">Rp. 156.43</strong>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td class="ps-4 bg-warning">
                                <input type="number" class="form-control text-danger" name="jarak_kirim"
                                    id="jarak_kirim">
                            </td>
                            <td class="bg-warning">
                                <select name="" id="" class="form-control">
                                    <option value="" selected disabled>Choose</option>
                                    <option value="1">Truck</option>
                                    <option value="1">Truck</option>
                                    <option value="1">Truck</option>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td>Biaya Dokumentasi</td>
                            <td>
                                <div class="row">
                                    <div class="col-4 text-center bg-warning">
                                        <span class="text-dark" id="biaya_dokumentasi">Rp. 75.00</span>
                                    </div>
                                    <div class="col-4">
                                        <select name="pakai_biaya_dokumentasi" id="pakai_biaya_dokumentasi"
                                            class="form-control">
                                            <option value="" selected disabled>Choose</option>
                                            <option value="0">Tidak</option>
                                            <option value="1">Iya</option>
                                        </select>
                                    </div>
                                    <div class="col-4 text-end">
                                        <strong class="text-primary" id="total_biaya_dokumentasi">Rp. 75.00</strong>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td>Biaya Door to Door</td>
                            <td>
                                <select name="biaya_door_to_door" id="biaya_door_to_door" class="form-control">
                                    <option value="" selected disabled>Choose</option>
                                    <option value="0">Tidak</option>
                                    <option value="1">Iya</option>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td>Keberangkatan : </td>
                            <td>
                                <div class="row">
                                    <div class="col-4 text-center">
                                        <select name="keberangkatan" id="keberangkatan" class="form-control">
                                            <option value="" selected disabled>Choose</option>
                                            <option value="0">SBY</option>
                                            <option value="1">JKT</option>
                                            <option value="2">BDG</option>
                                        </select>
                                    </div>
                                    <div class="col-4">
                                        <span class="text-dark" id="keberangkatan_tujuan">Surabaya Batam 40
                                            Feet</span>
                                    </div>
                                    <div class="col-4 text-end">
                                        <strong class="text-primary">Rp. -</strong>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-end">Tujuan :</td>
                            <td>
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <select name="tujuan" id="tujuan" class="form-control">
                                            <option value="" selected disabled>Choose</option>
                                            <option value="0">SBY</option>
                                            <option value="1">JKT</option>
                                            <option value="2">BDG</option>
                                        </select>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-end">Tipe Armada :</td>
                            <td>
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <strong class="text-primary" id="tipe_armada">40 feet</strong>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td class="text-end">Reet :</td>
                            <td>
                                <div class="row">
                                    <div class="col-12 text-center">
                                        <strong class="text-primary" id="reet">1.00</strong>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td class="text-center">
                                <strong class="text-primary" id="total_reet">1.00</strong>
                            </td>
                        </tr>
                        <!-- End Opersional -->

                        <tr>
                            <td class="bg-success">
                                <strong class="text-dark">HPP Operasional (M2)</strong>
                            </td>
                            <td class="text-end bg-success">
                                <strong class="text-dark" id="hpp_operasional">Rp. 7.268.37</strong>
                            </td>
                        </tr>

                        <tr>
                            <td>Consumable Equipment Tools</td>
                            <td>
                                <div class="row">
                                    <div class="col-4 text-center">
                                        <span class="text-dark" id="biaya_consumable">Rp. 0.00</span>
                                    </div>
                                    <div class="col-4">
                                        <select name="pakai_biaya_consumable" id="pakai_biaya_consumable"
                                            class="form-control">
                                            <option value="" selected disabled>Choose</option>
                                            <option value="0">Tidak</option>
                                            <option value="1">Iya</option>
                                        </select>
                                    </div>
                                    <div class="col-4 text-end">
                                        <strong class="text-primary" id="total_biaya_consumable">Rp. 0.00</strong>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td class="bg-success">
                                <strong class="text-dark">HPP Equipment (M2)</strong>
                            </td>
                            <td class="text-end bg-success">
                                <strong class="text-dark" id="hpp_equipment">Rp. 150.56</strong>
                            </td>
                        </tr>

                        <tr>
                            <td>Entertain dan Biaya Lain-lain</td>
                            <td>
                                <div class="row">
                                    <div class="col-4 text-center">
                                        <span class="text-dark" id="biaya_entertain">Rp. 0.00</span>
                                    </div>
                                    <div class="col-4">
                                        <select name="pakai_biaya_entertain" id="pakai_biaya_entertain"
                                            class="form-control">
                                            <option value="" selected disabled>Choose</option>
                                            <option value="0">Tidak</option>
                                            <option value="1">Iya</option>
                                        </select>
                                    </div>
                                    <div class="col-4 text-end">
                                        <strong class="text-primary" id="total_biaya_entertain">Rp. 0.00</strong>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td class="bg-success">
                                <strong class="text-dark">HPP Entertain (M2)</strong>
                            </td>
                            <td class="text-end bg-success">
                                <strong class="text-dark" id="hpp_entertain">Rp. 638.89</strong>
                            </td>
                        </tr>

                        <tr>
                            <td></td>
                        </tr>

                        <tr>
                            <td class="bg-success">
                                <strong class="text-dark">HPP (Bahan Baku + Produksi + Sales (/m2))</strong>
                            </td>
                            <td class="text-end bg-success">
                                <strong class="text-dark" id="hpp_total">Rp. 112.227.36</strong>
                            </td>
                        </tr>

                        <tr>
                            <td><strong class="text-primary">Operasional</strong></td>
                            <td>
                                <div class="row">
                                    <div class="col-6 text-center">
                                        <strong class="text-primary">HPP</strong>
                                    </div>
                                    <div class="col-6 text-center">
                                        <strong class="text-primary">JUAL</strong>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td class="ps-4">
                                <span class="text-dark" id="bahan_baku">
                                    ULT7(Bolt System Roofing) Sengalume Tebal TCT 0.50 AZ 150 Lebar 1219 mm
                                    Natural Proyek
                                </span>
                            </td>
                            <td>
                                <div class="row">
                                    <div class="col-6 text-center">
                                        <select name="" id="" class="form-control">
                                            <option value="" selected disabled>Choose Type</option>
                                            <option value="">Harga 1</option>
                                            <option value="">Harga 2</option>
                                            <option value="">Harga 3</option>
                                        </select>
                                    </div>
                                    <div class="col-6 text-end">
                                        <strong class="text-primary" id="">Rp. 92.295.34 </strong>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td class="ps-4">
                                <span class="text-dark" id="">
                                    Konektor, Aksesoris, dan Upah Pabrikasi
                                </span>
                            </td>
                            <td>
                                <div class="row">
                                    <div class="col-6 text-center">
                                        <select name="" id="" class="form-control">
                                            <option value="" selected disabled>Choose Type</option>
                                            <option value="">Harga 1</option>
                                            <option value="">Harga 2</option>
                                            <option value="">Harga 3</option>
                                        </select>
                                    </div>
                                    <div class="col-6 text-end">
                                        <strong class="text-primary" id="">Rp. 92.295.34 </strong>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td class="ps-4">
                                <span class="text-dark" id="">
                                    Upah Pasang
                                </span>
                            </td>
                            <td>
                                <div class="row">
                                    <div class="col-6 text-center">
                                        <select name="" id="" class="form-control">
                                            <option value="" selected disabled>Choose Type</option>
                                            <option value="">Harga 1</option>
                                            <option value="">Harga 2</option>
                                            <option value="">Harga 3</option>
                                        </select>
                                    </div>
                                    <div class="col-6 text-end">
                                        <strong class="text-primary" id="">Rp. 92.295.34 </strong>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td class="ps-4">
                                <span class="text-dark" id="">
                                    Operasional
                                </span>
                            </td>
                            <td>
                                <div class="row">
                                    <div class="col-6 text-center">
                                        <select name="" id="" class="form-control">
                                            <option value="" selected disabled>Choose Type</option>
                                            <option value="">Harga 1</option>
                                            <option value="">Harga 2</option>
                                            <option value="">Harga 3</option>
                                        </select>
                                    </div>
                                    <div class="col-6 text-end">
                                        <strong class="text-primary" id="">Rp. 92.295.34 </strong>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td class="ps-4">
                                <span class="text-dark" id="">
                                    Consumable Equipment Tools
                                </span>
                            </td>
                            <td>
                                <div class="row">
                                    <div class="col-6 text-center">
                                        <select name="" id="" class="form-control">
                                            <option value="" selected disabled>Choose Type</option>
                                            <option value="">Harga 1</option>
                                            <option value="">Harga 2</option>
                                            <option value="">Harga 3</option>
                                        </select>
                                    </div>
                                    <div class="col-6 text-end">
                                        <strong class="text-primary" id="">Rp. 92.295.34 </strong>
                                    </div>
                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td class="ps-4">
                                <span class="text-dark" id="">
                                    Entertain dan Biaya Lain-lain
                                </span>
                            </td>
                            <td>
                                <div class="row">
                                    <div class="col-6 text-center">
                                        <select name="" id="" class="form-control">
                                            <option value="" selected disabled>Choose Type</option>
                                            <option value="">Harga 1</option>
                                            <option value="">Harga 2</option>
                                            <option value="">Harga 3</option>
                                        </select>
                                    </div>
                                    <div class="col-6 text-end">
                                        <strong class="text-primary" id="">Rp. 92.295.34 </strong>
                                    </div>
                                </div>
                            </td>
                        </tr>

                    </tbody>
                    <tfoot class="fw-bold">
                        <tr>
                            <td class="bg-success">HARGA JUAL PENAWARAN EXCLUDE PPN</td>
                            <td class="text-end bg-success">
                                <strong class="text-dark" id="total_exclude_ppn">Rp. 135.795.10</strong>
                            </td>
                        </tr>
                        <tr>
                            <td class="bg-success">HARGA JUAL PENAWARAN INCLUDE PPN</td>
                            <td class="text-end bg-success">
                                <strong class="text-dark" id="total_include_ppn">Rp. 150.732.56</strong>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>
</body>

</html>
