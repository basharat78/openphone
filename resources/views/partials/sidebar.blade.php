<div class="bg-dark text-white p-3" style="width:250px; min-height:100vh;">
    <h4 class="text-center">QC Panel</h4>
    <hr>

    <ul class="nav flex-column">
        <li class="nav-item">
            <a href="{{ route('qc.dashboard') }}" class="nav-link text-white">
                Dashboard
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('qc.reports') }}" class="nav-link text-white">
                Reports
            </a>
        </li>

        <li class="nav-item">
            <a href="{{ route('qc.inspections') }}" class="nav-link text-white">
                Inspections
            </a>
        </li>
    </ul>
</div>
