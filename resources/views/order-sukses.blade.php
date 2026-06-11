@extends('layouts.app')

@section('content')
<div style="padding: 50px 20px; color: #fff; background: #121212; min-height: 100vh; display: flex; justify-content: center; align-items: center;">
    <div style="background: #1e1e1e; width: 100%; max-width: 550px; padding: 40px; border-radius: 8px; border: 1px solid #2d2d2d; text-align: center;">
        <div style="font-size: 50px; color: #28a745; margin-bottom: 20px;">🎉</div>
        <h2 style="color: gold; margin-top: 0;">Pesanan Berhasil Diajukan!</h2>
        <p style="color: #ccc; line-height: 1.6; margin-bottom: 25px;">
            @if(session('tipe') === 'custom')
                Pengajuan desain custom untuk brand <strong>{{ session('nama_brand') }}</strong> ({{ session('layanan') }}) telah tersimpan. Silakan hubungi admin untuk negosiasi harga.
            @else
                Pesanan brand <strong>{{ session('nama_brand') }}</strong> ({{ session('layanan') }}) berhasil diajukan dan sedang kami proses!
            @endif
        </p>

        @if(session('tipe') === 'custom')
        <!-- POIN 3: Bagian Informasi Pembayaran -->
        <div style="background: #2a2a2a; border-radius: 6px; padding: 20px; text-align: left; margin-bottom: 30px; border: 1px solid #444;">
            <h4 style="margin-top: 0; color: gold; margin-bottom: 12px;">💳 Informasi Negosiasi & Pembayaran:</h4>
            <p style="color: #bbb; font-size: 14px; line-height: 1.6; margin: 0 0 12px 0;">
                Kesepakatan harga & detail pengerjaan akan didiskusikan langsung dengan Admin via WhatsApp. Setelah deal, Anda dapat melakukan pembayaran melalui salah satu channel berikut:
            </p>
            <ol style="margin: 0; padding-left: 20px; color: #bbb; font-size: 14px; line-height: 1.8;">
                <li>Transfer Bank BCA (No. Rek: 123-456-789 a/n PixelStudio)</li>
                <li>Transfer Bank Mandiri (No. Rek: 987-654-321 a/n PixelStudio)</li>
                <li>E-Wallet Dana (0812-3456-7890)</li>
                <li>E-Wallet OVO (0812-3456-7890)</li>
            </ol>
        </div>

        <p style="color: #aaa; font-size: 13px; margin-bottom: 20px;">
            Silakan klik tombol di bawah untuk mendiskusikan harga & kesepakatan detail desain Anda dengan WhatsApp Admin:
        </p>

        @php
            $waText = 'Halo Admin PixelStudio, saya ingin mendiskusikan pesanan custom untuk brand *' . session('nama_brand') . '* dengan layanan *' . session('layanan') . '*. Terima kasih!';
        @endphp
        <a href="https://wa.me/628123456789?text={{ rawurlencode($waText) }}"
           target="_blank"
           style="display: inline-block; background: #25d366; color: white; text-decoration: none; padding: 14px 30px; border-radius: 5px; font-weight: bold; font-size: 15px; width: 100%; box-sizing: border-box;">
            💬 Hubungi Admin via WhatsApp (Deal Harga)
        </a>
        @else
        <div style="background: rgba(40, 167, 69, 0.08); border: 1px dashed #28a745; border-radius: 6px; padding: 20px; text-align: left; margin-bottom: 30px; color: #4ade80;">
            <p style="margin: 0; font-size: 14px; line-height: 1.6;">
                <strong>Terima Kasih!</strong> Bukti transfer pembayaran Anda telah kami terima. Admin kami akan segera memvalidasi pesanan Anda.
            </p>
        </div>

        <p style="color: #aaa; font-size: 13px; margin-bottom: 20px;">
            Jika ada kendala atau masukan terkait pesanan Anda, silakan hubungi admin via WhatsApp:
        </p>

        @php
            $waText = 'Halo Admin PixelStudio, saya ingin menanyakan mengenai pesanan untuk brand *' . session('nama_brand') . '* yang telah saya submit. Terima kasih!';
        @endphp
        <a href="https://wa.me/6283111923563?text={{ rawurlencode($waText) }}"
           target="_blank"
           style="display: inline-block; background: #25d366; color: white; text-decoration: none; padding: 14px 30px; border-radius: 5px; font-weight: bold; font-size: 15px; width: 100%; box-sizing: border-box;">
            💬 Hubungi Admin via WhatsApp
        </a>
        @endif

        <div style="margin-top: 25px;">
            <a href="{{ route('pesanan') }}" style="color: #888; text-decoration: none; font-size: 13px;">Lihat Riwayat Pesanan Saya →</a>
        </div>
    </div>
</div>
@endsection
