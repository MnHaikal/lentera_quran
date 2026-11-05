<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode Verifikasi Akun - Lentera Quran</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f6f7f9; font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif; color: #2d3748; -webkit-font-smoothing: antialiased;">
    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color: #f6f7f9; padding: 30px 15px;">
        <tr>
            <td align="center">
                <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="max-width: 540px; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05); border: 1px solid #e2e8f0;">
                    {{-- Header --}}
                    <tr>
                        <td align="center" style="background-color: #0B2F4C; padding: 32px 24px; text-align: center;">
                            <h1 style="margin: 0; color: #ffffff; font-size: 24px; font-weight: 700; letter-spacing: -0.5px;">
                                Lentera Qur'an
                            </h1>
                            <p style="margin: 6px 0 0 0; color: #D4A244; font-size: 13px; font-weight: 500; letter-spacing: 0.5px; text-transform: uppercase;">
                                Platform Al-Qur'an &amp; Doa Digital
                            </p>
                        </td>
                    </tr>

                    {{-- Body --}}
                    <tr>
                        <td style="padding: 36px 32px;">
                            <p style="margin: 0 0 16px 0; font-size: 16px; line-height: 1.6; color: #1a202c;">
                                <strong>Assalamu'alaikum Warahmatullahi Wabarakatuh,</strong>
                            </p>
                            <p style="margin: 0 0 20px 0; font-size: 15px; line-height: 1.6; color: #4a5568;">
                                Halo <strong>{{ $name }}</strong>, terima kasih telah mendaftar di <strong>Lentera Quran</strong>. Untuk memastikan alamat email Anda valid dan mengaktifkan akun Anda, masukkan 6 digit kode OTP berikut pada halaman pendaftaran:
                            </p>

                            {{-- OTP Box --}}
                            <div style="background-color: #FBF8F2; border: 2px dashed #B9892E; border-radius: 12px; padding: 22px; text-align: center; margin: 26px 0;">
                                <div style="font-size: 13px; font-weight: 600; color: #8C6615; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 8px;">
                                    Kode Verifikasi (OTP)
                                </div>
                                <div style="font-size: 34px; font-weight: 800; letter-spacing: 10px; color: #0B2F4C; font-family: Consolas, 'Liberation Mono', Menlo, Courier, monospace;">
                                    {{ $otp }}
                                </div>
                                <div style="font-size: 12px; color: #718096; margin-top: 8px;">
                                    Berlaku selama <strong>10 menit</strong>
                                </div>
                            </div>

                            <p style="margin: 20px 0 10px 0; font-size: 14px; line-height: 1.6; color: #4a5568;">
                                Jika Anda tidak merasa melakukan pendaftaran akun di Lentera Quran, silakan abaikan pesan email ini. Akun Anda tidak akan aktif tanpa verifikasi kode ini.
                            </p>
                            
                            <p style="margin: 16px 0 0 0; font-size: 13px; line-height: 1.5; color: #e53e3e; background-color: #fff5f5; border-left: 3px solid #e53e3e; padding: 10px 14px; border-radius: 4px;">
                                <strong>Peringatan Keamanan:</strong> Jangan berikan kode OTP ini kepada siapa pun demi menjaga keamanan akun Anda.
                            </p>
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td align="center" style="background-color: #f7fafc; padding: 20px 24px; border-top: 1px solid #edf2f7; text-align: center;">
                            <p style="margin: 0; font-size: 12px; color: #a0aec0; line-height: 1.5;">
                                &copy; {{ date('Y') }} Lentera Quran. Hak Cipta Dilindungi Undang-Undang.<br>
                                Platform Al-Qur'an digital berbahasa Indonesia bebas iklan.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>

