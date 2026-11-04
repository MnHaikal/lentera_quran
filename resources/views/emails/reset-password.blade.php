<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Atur Ulang Kata Sandi Akun - Lentera Quran</title>
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
                                Halo <strong>{{ $name }}</strong>, kami menerima permintaan untuk mengatur ulang kata sandi akun <strong>Lentera Quran</strong> Anda. Silakan klik tombol di bawah ini untuk membuat kata sandi baru:
                            </p>

                            {{-- CTA Button Box --}}
                            <div style="text-align: center; margin: 30px 0 24px 0;">
                                <a href="{{ $url }}" target="_blank" style="display: inline-block; background-color: #D4A244; color: #0B2F4C; font-size: 16px; font-weight: 700; text-decoration: none; padding: 14px 32px; border-radius: 50px; box-shadow: 0 2px 6px rgba(212, 162, 68, 0.35); text-align: center;">
                                    Atur Ulang Kata Sandi
                                </a>
                            </div>

                            <div style="background-color: #FBF8F2; border-radius: 8px; padding: 12px 16px; text-align: center; margin-bottom: 24px;">
                                <span style="font-size: 13px; color: #8C6615; font-weight: 500;">
                                    Tautan ini hanya berlaku selama <strong>{{ $count }} menit</strong>.
                                </span>
                            </div>

                            <p style="margin: 0 0 16px 0; font-size: 14px; line-height: 1.6; color: #4a5568;">
                                Jika Anda tidak meminta pengaturan ulang kata sandi, silakan abaikan pesan email ini. Kata sandi akun Anda tetap aman dan tidak akan diubah.
                            </p>
                            
                            <p style="margin: 16px 0 0 0; font-size: 13px; line-height: 1.5; color: #e53e3e; background-color: #fff5f5; border-left: 3px solid #e53e3e; padding: 10px 14px; border-radius: 4px;">
                                <strong>Peringatan Keamanan:</strong> Jangan berikan tautan ini kepada siapa pun demi menjaga keamanan akun Anda.
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

