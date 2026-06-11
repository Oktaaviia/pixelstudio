@extends('layouts.app')

@section('content')
<div style="padding: 40px; color: #fff; background: #121212; min-height: 100vh;">
    <div style="max-width: 800px; margin: 0 auto;">
        
        <!-- Info Akun User -->
        <div style="background: #1e1e1e; padding: 25px; border-radius: 8px; border: 1px solid #2d2d2d; margin-bottom: 30px;">
            <h2 style="color: gold; margin-top: 0; margin-bottom: 5px;">Profil Pengguna</h2>
            <p style="color: #aaa; margin-bottom: 15px;">Detail informasi akun Anda di PixelStudio.</p>
            <div style="font-size: 15px;">
                👤 Username : <strong>{{ $user_info->username }}</strong><br>
                📧 Email : <span>{{ $user_info->email }}</span>
            </div>
        </div>

        <!-- POIN 2: Tabel Riwayat Pesanan Customer -->
        <div style="background: #1e1e1e; padding: 25px; border-radius: 8px; border: 1px solid #2d2d2d;">
            <h3 style="margin-top: 0; margin-bottom: 20px; color: gold;">📦 Riwayat Pemesanan Anda</h3>
            
            @if($riwayat_pesanan->isEmpty())
                <p style="color: #666; text-align: center; padding: 20px 0;">Anda belum pernah melakukan pemesanan desain.</p>
            @else
                <table style="width: 100%; border-collapse: collapse; text-align: left;">
                    <thead>
                        <tr style="border-bottom: 2px solid #444; color: #aaa; font-size: 14px;">
                            <th style="padding: 10px;">Nama Brand</th>
                            <th style="padding: 10px;">Layanan / Paket</th>
                            <th style="padding: 10px;">Status Pesanan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($riwayat_pesanan as $pesan)
                        <tr style="border-bottom: 1px solid #2d2d2d; font-size: 14px;">
                            <td style="padding: 12px;"><strong>{{ $pesan->nama_brand }}</strong></td>
                            <td style="padding: 12px;">{{ $pesan->layanan }} <br> <small style="color: gold;">{{ $pesan->paket }}</small></td>
                            <td style="padding: 12px;">
                                @if($pesan->status == 'Menunggu Validasi')
                                    <span style="background: #4d3d00; color: #ffc107; padding: 3px 6px; border-radius: 4px; font-size: 12px;">⏳ {{ $pesan->status }}</span>
                                @elseif($pesan->status == 'Diproses')
                                    <span style="background: #0d3a47; color: #17a2b8; padding: 3px 6px; border-radius: 4px; font-size: 12px;">⚙️ {{ $pesan->status }}</span>
                                @else
                                    <span style="background: #0f3d1a; color: #28a745; padding: 3px 6px; border-radius: 4px; font-size: 12px;">🏁 {{ $pesan->status }}</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>

    </div>
</div>
@endsection
