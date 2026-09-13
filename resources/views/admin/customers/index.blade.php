<x-admin-layout>
    <x-slot name="header">Data Pelanggan</x-slot>

    <style>
        .admin-customers-table-wrap {
            border: 0.5px solid #d8e8d8;
            border-radius: 12px;
            overflow: hidden;
        }
        .admin-customers-table {
            width: 100%;
            border-collapse: collapse;
            margin: 0;
        }
        .admin-customers-table thead th {
            background: #f4f8f4;
            font-size: 12px;
            font-weight: 500;
            color: #2d5033;
            padding: 10px 16px;
            text-align: left;
            border-bottom: 0.5px solid #d8e8d8;
        }
        .admin-customers-table thead th.text-center {
            text-align: center;
        }
        .admin-customers-table tbody td {
            font-size: 13px;
            padding: 10px 16px;
            border-bottom: 0.5px solid #f4f4f4;
            vertical-align: middle;
        }
        .admin-customers-table tbody tr:last-child td {
            border-bottom: none;
        }
        .admin-customers-table .orders-count-badge {
            display: inline-block;
            background: #EAF3DE;
            color: #3B6D11;
            font-size: 11px;
            padding: 2px 8px;
            border-radius: 4px;
            font-weight: 500;
        }
    </style>

    <div class="card border-0 shadow-sm">
        <div class="admin-customers-table-wrap">
            <div class="table-responsive">
                <table class="admin-customers-table mb-0">
                    <thead>
                        <tr>
                            <th style="width: 56px;">No</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>Tanggal Daftar</th>
                            <th class="text-center">Total Pesanan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customers as $customer)
                            <tr>
                                <td>{{ ($customers->currentPage() - 1) * $customers->perPage() + $loop->iteration }}</td>
                                <td class="fw-semibold">{{ $customer->name }}</td>
                                <td>{{ $customer->email }}</td>
                                <td>{{ $customer->created_at->format('d M Y') }}</td>
                                <td class="text-center">
                                    <span class="orders-count-badge">{{ $customer->orders_count }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-5" style="font-size: 13px; color: #888;">
                                    Belum ada pelanggan terdaftar.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @if($customers->hasPages())
        <div class="mt-3 d-flex justify-content-center">
            {{ $customers->links() }}
        </div>
    @endif
</x-admin-layout>
