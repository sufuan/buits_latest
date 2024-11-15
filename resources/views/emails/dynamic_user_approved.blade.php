<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $template->title ?? 'Account Approved' }}</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 20px auto; background-color: #ffffff; padding: 20px; border-radius: 8px; box-shadow: 0 0 10px rgba(0, 0, 0, 0.1); }
        .center-logo { display: block; margin: 0 auto 20px; width: 100px; height: 100px; }
        .btn { display: inline-block; padding: 10px 20px; color: #fff; background-color: #0066cc; text-decoration: none; border-radius: 5px; margin-top: 20px; }
        .footer a { color: #0066cc; text-decoration: none; margin: 0 10px; }
        .social-icons img { width: 24px; margin: 0 10px; }
    </style>
</head>
<body>
    <div class="container">
        @if($template->logo)
            <img src="{{ asset('storage/' . $template->logo) }}" alt="Logo" class="center-logo">
        @endif

        <h1>{{ $template->title }}</h1>

        <p>Dear {{ $user->name }},</p>
        <p>{!! nl2br(e($template->body)) !!}</p>

        <a href="{{ $template->button_url }}" class="btn">{{ $template->button }}</a>

        <div class="footer">
            <p>{{ $template->footer_text }}</p>
            <div class="social-icons">
                @if($template->facebook)<a href="{{ $template->facebook }}"><img src="{{ asset('path/to/facebook-icon.png') }}" alt="Facebook"></a>@endif
                @if($template->instagram)<a href="{{ $template->instagram }}"><img src="{{ asset('path/to/instagram-icon.png') }}" alt="Instagram"></a>@endif
                @if($template->twitter)<a href="{{ $template->twitter }}"><img src="{{ asset('path/to/twitter-icon.png') }}" alt="Twitter"></a>@endif
            </div>
            <p>{{ $template->copyright_text }}</p>
        </div>
    </div>
</body>
</html>
