@extends('layouts.app')

@section('title', 'Laporan')

@section('content')

@php
$routePrefix = auth()->user()->isAdmin() ? 'admin' : 'pimpinan';
@endphp

<div class="space-y-6">

    <div>

        <h1 class="text-3xl font-bold text-slate-800 dark:text-white">
            Laporan
        </h1>

        <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">
            Download laporan presensi dan honorarium dalam format Excel maupun PDF.
        </p>

    </div>

    <div class="grid gap-6 lg:grid-cols-2">

        {{-- Presensi --}}
        <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-slate-800">

            <div class="border-b border-slate-200 p-6 dark:border-slate-800">

                <h2 class="text-lg font-semibold text-slate-800 dark:text-white">
                    Laporan Presensi
                </h2>

            </div>

            <div class="space-y-5 p-6">

                <div class="grid gap-5 sm:grid-cols-2">

                    <div>

                        <label class="mb-2 block text-sm font-medium">
                            Bulan
                        </label>

                        <select id="bulan-presensi"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 dark:border-slate-700 dark:bg-slate-800">

                            @foreach (range(1, 12) as $b)
                            <option value="{{ $b }}" {{ $bulan == $b ? 'selected' : '' }}>

                                {{ DateTime::createFromFormat('!m', $b)->format('F') }}

                            </option>
                            @endforeach

                        </select>

                    </div>

                    <div>

                        <label class="mb-2 block text-sm font-medium">
                            Tahun
                        </label>

                        <select id="tahun-presensi"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 dark:border-slate-700 dark:bg-slate-800">

                            @foreach (range(date('Y') - 2, date('Y')) as $t)
                            <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>

                                {{ $t }}

                            </option>
                            @endforeach

                        </select>

                    </div>

                </div>

                <div class="grid gap-3">

                    <button onclick="exportPresensi('excel')"
                        class="rounded-xl bg-emerald-600 px-5 py-3 font-medium text-white transition hover:bg-emerald-700">

                        Download Excel

                    </button>

                    <button onclick="exportPresensi('pdf')"
                        class="rounded-xl bg-red-600 px-5 py-3 font-medium text-white transition hover:bg-red-700">

                        Download PDF

                    </button>

                </div>

            </div>

        </div>

        {{-- Honorarium --}}
        <div class="rounded-2xl bg-white shadow-sm ring-1 ring-slate-200 dark:bg-slate-900 dark:ring-slate-800">

            <div class="border-b border-slate-200 p-6 dark:border-slate-800">

                <h2 class="text-lg font-semibold text-slate-800 dark:text-white">
                    Laporan Honorarium
                </h2>

            </div>

            <div class="space-y-5 p-6">

                <div class="grid gap-5 sm:grid-cols-2">

                    <div>

                        <label class="mb-2 block text-sm font-medium">
                            Bulan
                        </label>

                        <select id="bulan-honorarium"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 dark:border-slate-700 dark:bg-slate-800">

                            @foreach (range(1, 12) as $b)
                            <option value="{{ $b }}" {{ $bulan == $b ? 'selected' : '' }}>

                                {{ DateTime::createFromFormat('!m', $b)->format('F') }}

                            </option>
                            @endforeach

                        </select>

                    </div>

                    <div>

                        <label class="mb-2 block text-sm font-medium">
                            Tahun
                        </label>

                        <select id="tahun-honorarium"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 dark:border-slate-700 dark:bg-slate-800">

                            @foreach (range(date('Y') - 2, date('Y')) as $t)
                            <option value="{{ $t }}" {{ $tahun == $t ? 'selected' : '' }}>

                                {{ $t }}

                            </option>
                            @endforeach

                        </select>

                    </div>

                </div>

                <div class="grid gap-3">

                    <button onclick="exportHonorarium('excel')"
                        class="rounded-xl bg-emerald-600 px-5 py-3 font-medium text-white transition hover:bg-emerald-700">

                        Download Excel

                    </button>

                    <button onclick="exportHonorarium('pdf')"
                        class="rounded-xl bg-red-600 px-5 py-3 font-medium text-white transition hover:bg-red-700">

                        Download PDF

                    </button>

                </div>

            </div>

        </div>

    </div>

</div>

@push('scripts')
<script>
    function exportPresensi(type) {

        const bulan = document.getElementById('bulan-presensi').value;
        const tahun = document.getElementById('tahun-presensi').value;

        const url = type === 'excel' ?
            "{{ route($routePrefix.'.laporan.presensi.excel') }}" :
            "{{ route($routePrefix.'.laporan.presensi.pdf') }}";

        window.location.href = url + `?bulan=${bulan}&tahun=${tahun}`;

    }

    function exportHonorarium(type) {

        const bulan = document.getElementById('bulan-honorarium').value;
        const tahun = document.getElementById('tahun-honorarium').value;

        const url = type === 'excel' ?
            "{{ route($routePrefix.'.laporan.honorarium.excel') }}" :
            "{{ route($routePrefix.'.laporan.honorarium.pdf') }}";

        window.location.href = url + `?bulan=${bulan}&tahun=${tahun}`;

    }
</script>
@endpush

@endsection