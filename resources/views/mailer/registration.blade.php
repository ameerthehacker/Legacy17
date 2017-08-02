<p>Hi, {{ $user->full_name}}</p>
<p>Thanks for registering in legacy17</p>
{{ link_to_route('auth.activate', 'Click Here', ['email' => $user->email, 'activation_code' => $user->activation_code]) }} to confirm your account