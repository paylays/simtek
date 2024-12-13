<nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
    <div class="sb-sidenav-menu">
        <div class="nav">
            <div class="sb-sidenav-menu-heading">Core</div>
            <a class="nav-link" href="{{ route('dashboard') }}">
                <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                Dashboard
            </a>

            <div class="sb-sidenav-menu-heading">Master Data</div>
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseMasterData" aria-expanded="false" aria-controls="collapseMasterData">
                <div class="sb-nav-link-icon"><i class="fas fa-database"></i></div>
                Master Data
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseMasterData" aria-labelledby="headingOne" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="{{ route('medicines') }}">Obat</a>
                    <a class="nav-link" href="{{ route('medicinedevices') }}">Alat Kesehatan</a>
                    <a class="nav-link" href="{{ route('units') }}">Satuan</a>
                    <a class="nav-link" href="{{ route('categories') }}">Kategori</a>
                    <a class="nav-link" href="{{ route('suppliers') }}">Supplier</a>
                </nav>
            </div>

            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapsePengelola" aria-expanded="false" aria-controls="collapsePengelola">
                <div class="sb-nav-link-icon"><i class="fas fa-folder-open"></i></div>
                Pengelola
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapsePengelola" aria-labelledby="headingThree" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="{{ route('patients') }}">Pasien</a>
                    <a class="nav-link" href="{{ route('doctors') }}">Dokter</a>
                    <a class="nav-link" href="{{ route('employees') }}">Karyawan</a>
                </nav>
            </div>

            <div class="sb-sidenav-menu-heading">Transaksi</div>
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseTransaksi" aria-expanded="false" aria-controls="collapseTransaksi">
                <div class="sb-nav-link-icon"><i class="fas fa-exchange-alt"></i></div>
                Transaksi
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseTransaksi" aria-labelledby="headingTwo" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="{{ route('transactions') }}">Transaksi</a>
                </nav>
            </div>

            <div class="sb-sidenav-menu-heading">Laporan</div>
            <a class="nav-link collapsed" href="#" data-bs-toggle="collapse" data-bs-target="#collapseLaporan" aria-expanded="false" aria-controls="collapseLaporan">
                <div class="sb-nav-link-icon"><i class="fas fa-file-alt"></i></div>
                Laporan
                <div class="sb-sidenav-collapse-arrow"><i class="fas fa-angle-down"></i></div>
            </a>
            <div class="collapse" id="collapseLaporan" aria-labelledby="headingThree" data-bs-parent="#sidenavAccordion">
                <nav class="sb-sidenav-menu-nested nav">
                    <a class="nav-link" href="{{ route('reportsmedicine') }}">Laporan Obat</a>
                    <a class="nav-link" href="{{ route('reportsmedicinedevice') }}">Laporan Alat Kesehatan</a>
                    <a class="nav-link" href="{{ route('reportstransaction') }}">Laporan Transaksi</a>
                </nav>
            </div>
        </div>
    </div>
</nav>
