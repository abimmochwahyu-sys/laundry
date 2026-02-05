@extends('layouts.master')
@section('title', 'Data Pelanggan')
@section('content')
    <h1 class="h3 mb-4 text-gray-800">Data Pelanggan</h1>
    <!-- <a href="{{ route('admin.pelanggan.create') }}" class="btn btn-primary mb-3">+ Tambah Pelanggan</a> -->
    <div class="card shadow">
        <div class="card-body">
            <table class="table table-bordered">
                <thead class="thead-light">
                    <tr class="text-center">
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Alamat</th>
                        <th>Telepon</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pelanggans as $p)
                        <tr>
                            <td>{{ $p->id }}</td>
                            <td>{{ $p->user->name }}</td>
                            <td>{{ $p->user->email }}</td>
                            <td>{{ $p->alamat }}</td>
                            <td>{{ $p->telepon }}</td>

                            <td>
                                <a href="{{ route('admin.pelanggan.edit', $p->id) }}" class="btn btn-warning btn-sm">Edit</a>

                                <form action="{{ route('admin.pelanggan.destroy', $p->id) }}" method="POST"
                                    style="display:inline-block;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Yakin ingin hapus?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>

            </table>

            {{ $pelanggans->links() }}
        </div>
    </div>
@endsection
