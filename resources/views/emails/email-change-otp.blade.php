<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kode Verifikasi Perubahan Email - Lentera Quran</title>
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
                                Halo <strong>{{ $name }}</strong>, kami menerima permintaan untuk mengganti alamat email akun <strong>Lentera Quran</strong> Anda ke alamat email ini (<strong>{{ $newEmail }}</strong>).
                            </p>
                            <p style="margin: 0 0 20px 0; font-size: 15px; line-height: 1.6; color: #4a5568;">
                                Untuk memverifikasi bahwa alamat email ini valid dan aktif, masukkan 6 digit kode OTP berikut pada dialog perubahan email:
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
                                Jika Anda tidak merasa meminta perubahan alamat email di Lentera Quran, silakan abaikan pesan email ini. Alamat email akun Anda tidak akan berubah tanpa verifikasi kode ini.
                            </p>
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="background-color: #f8fafc; padding: 20px 32px; border-top: 1px solid #e2e8f0; text-align: center;">
                            <p style="margin: 0; font-size: 12px; color: #a0aec0; line-height: 1.5;">
                                Pesan ini dikirim secara otomatis oleh sistem <strong>Lentera Quran</strong>.<br>
                                Mohon untuk tidak membalas email ini.
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>

