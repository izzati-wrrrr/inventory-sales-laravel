<x-guest-layout>
    <div style="min-height: 100vh; display: flex; align-items: center; justify-content: center; background: radial-gradient(circle at 10% 20%, #1e3e2b 0%, #0d1f15 90%); padding: 24px; position: relative; overflow: hidden; font-family: 'Figtree', sans-serif;">
        
        <!-- Ornamen Background Glow Efek Aesthetic -->
        <div style="position: absolute; width: 450px; height: 450px; background: rgba(52, 211, 153, 0.12); filter: blur(90px); border-radius: 50%; top: -100px; left: -100px; pointer-events: none;"></div>
        <div style="position: absolute; width: 400px; height: 400px; background: rgba(16, 185, 129, 0.1); filter: blur(80px); border-radius: 50%; bottom: -100px; right: -100px; pointer-events: none;"></div>

        <!-- Card Login Floating Center -->
        <div style="width: 100%; max-width: 440px; background: rgba(255, 255, 255, 0.98); backdrop-filter: blur(16px); border-radius: 20px; box-shadow: 0 20px 50px rgba(0, 0, 0, 0.35); border: 1px solid rgba(255, 255, 255, 0.2); padding: 40px; position: relative; z-index: 10;">
            
            <!-- Logo Header Melayang -->
            <div style="text-align: center; margin-bottom: 28px;">
                <div style="width: 56px; height: 56px; background: #ecfdf5; border-radius: 16px; display: inline-flex; align-items: center; justify-content: center; margin-bottom: 14px; box-shadow: inset 0 0 0 1px rgba(16, 185, 129, 0.2);">
                    <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="#059669" stroke-width="2.3" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                        <polyline points="9 22 9 12 15 12 15 22"></polyline>
                    </svg>
                </div>
                <h2 style="font-size: 22px; font-weight: 800; color: #064e3b; margin: 0; letter-spacing: -0.3px;">TOKO SEMBAKO</h2>
                <p style="font-size: 13px; color: #6b7280; margin: 6px 0 0 0;">Portal Masuk Pengelola & Kasir Toko</p>
            </div>

            <!-- Session Status / Notification -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" style="display: flex; flex-direction: column; gap: 18px;">
                @csrf

                <!-- Input Email -->
                <div>
                    <label for="email" style="display: block; font-size: 12px; font-weight: 700; color: #374151; margin-bottom: 6px; text-transform: uppercase; letter-spacing: 0.5px;">Email Akses</label>
                    <input id="email" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="nama@tokosembako.com" 
                        style="width: 100%; padding: 12px 16px; border-radius: 10px; border: 1.5px solid #e5e7eb; font-size: 14px; outline: none; background: #f9fafb; transition: all 0.2s;"
                        onfocus="this.style.borderColor='#059669'; this.style.background='#ffffff'; this.style.boxShadow='0 0 0 4px rgba(5, 150, 105, 0.12)';" 
                        onblur="this.style.borderColor='#e5e7eb'; this.style.background='#f9fafb'; this.style.boxShadow='none';">
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Input Password -->
                <div>
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 6px;">
                        <label for="password" style="font-size: 12px; font-weight: 700; color: #374151; text-transform: uppercase; letter-spacing: 0.5px;">Password</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" style="font-size: 12px; font-weight: 600; color: #059669; text-decoration: none;">Lupa kata sandi?</a>
                        @endif
                    </div>
                    <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" 
                        style="width: 100%; padding: 12px 16px; border-radius: 10px; border: 1.5px solid #e5e7eb; font-size: 14px; outline: none; background: #f9fafb; transition: all 0.2s;"
                        onfocus="this.style.borderColor='#059669'; this.style.background='#ffffff'; this.style.boxShadow='0 0 0 4px rgba(5, 150, 105, 0.12)';" 
                        onblur="this.style.borderColor='#e5e7eb'; this.style.background='#f9fafb'; this.style.boxShadow='none';">
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Checkbox Remember -->
                <div style="display: flex; align-items: center;">
                    <input id="remember_me" type="checkbox" name="remember" style="width: 16px; height: 16px; border-radius: 4px; border: 1.5px solid #d1d5db; accent-color: #059669; cursor: pointer;">
                    <label for="remember_me" style="margin-left: 8px; font-size: 13px; color: #4b5563; cursor: pointer; font-weight: 500;">Ingat akun saya</label>
                </div>

                <!-- Tombol Submit -->
                <button type="submit" style="width: 100%; background: linear-gradient(135deg, #059669 0%, #047857 100%); color: white; border: none; padding: 14px; border-radius: 10px; font-size: 15px; font-weight: 700; cursor: pointer; transition: all 0.2s; box-shadow: 0 4px 14px rgba(5, 150, 105, 0.35); margin-top: 6px;"
                    onmouseover="this.style.transform='translateY(-1px)'; this.style.boxShadow='0 6px 20px rgba(5, 150, 105, 0.45)';" 
                    onmouseout="this.style.transform='none'; this.style.boxShadow='0 4px 14px rgba(5, 150, 105, 0.35)';">
                    Masuk Sekarang →
                </button>
            </form>

            <!-- Watermark / Hak Cipta Bawah Card -->
            <div style="text-align: center; margin-top: 24px; font-size: 12px; color: #9ca3af;">
                &copy; {{ date('Y') }} POS Sembako System • Version 1.0
            </div>
        </div>

    </div>
</x-guest-layout>