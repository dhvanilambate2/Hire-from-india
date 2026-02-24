<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login OTP</title>
</head>
<body style="margin:0;padding:0;background-color:#f8fafc;font-family:'Segoe UI',Tahoma,Geneva,Verdana,sans-serif;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color:#f8fafc;padding:40px 20px;">
        <tr>
            <td align="center">
                <table role="presentation" width="450" cellspacing="0" cellpadding="0" style="background-color:#ffffff;border-radius:16px;box-shadow:0 4px 6px rgba(0,0,0,0.05);overflow:hidden;">

                    {{-- Header --}}
                    <tr>
                        <td style="background:linear-gradient(135deg,#667eea 0%,#764ba2 100%);padding:30px;text-align:center;">
                            <h1 style="color:#ffffff;margin:0;font-size:24px;font-weight:700;">
                                Hire<span style="color:#e0e7ff;">Form</span>India
                            </h1>
                            <p style="color:#e0e7ff;margin:8px 0 0;font-size:14px;">Login Verification</p>
                        </td>
                    </tr>

                    {{-- Body --}}
                    <tr>
                        <td style="padding:40px 30px;">
                            <p style="color:#334155;font-size:16px;margin:0 0 8px;">
                                Hello <strong>{{ $user->name }}</strong>,
                            </p>
                            <p style="color:#64748b;font-size:14px;line-height:1.6;margin:0 0 30px;">
                                We received a login request for your account. Use the OTP below to complete your sign-in:
                            </p>

                            {{-- OTP Box --}}
                            <div style="text-align:center;margin:0 0 30px;">
                                <div style="background:#f1f5f9;border-radius:12px;padding:20px;display:inline-block;">
                                    <span style="font-size:36px;font-weight:800;letter-spacing:12px;color:#4f46e5;font-family:'Courier New',monospace;">
                                        {{ $otp }}
                                    </span>
                                </div>
                            </div>

                            <p style="color:#64748b;font-size:13px;line-height:1.6;margin:0 0 8px;">
                                <strong style="color:#dc2626;">⏰ This OTP expires in 5 minutes.</strong>
                            </p>
                            <p style="color:#64748b;font-size:13px;line-height:1.6;margin:0 0 20px;">
                                If you didn't request this login, please ignore this email or contact support if you have concerns.
                            </p>

                            {{-- Security Info --}}
                            <div style="background:#fef3c7;border-radius:10px;padding:14px 18px;border-left:4px solid #f59e0b;">
                                <p style="color:#92400e;font-size:12px;margin:0;font-weight:500;">
                                    🔒 <strong>Security Tip:</strong> Never share your OTP with anyone. Our team will never ask for your OTP.
                                </p>
                            </div>
                        </td>
                    </tr>

                    {{-- Footer --}}
                    <tr>
                        <td style="background:#f8fafc;padding:20px 30px;text-align:center;border-top:1px solid #e2e8f0;">
                            <p style="color:#94a3b8;font-size:12px;margin:0;">
                                © {{ date('Y') }} HireFormIndia. All rights reserved.
                            </p>
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>
