<!-- Login Modal -->
<div id="login-model" class="fixed inset-0 z-50 flex items-center justify-center hidden" style="display:none;">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="closeLoginViewer()"></div>
    <div class="relative bg-white rounded-2xl shadow-2xl w-full max-w-sm mx-4 overflow-hidden animate-[popup_0.3s_ease]">
        <!-- Header -->
        <div class="bg-red-900 px-6 py-5 text-center relative">
            <h4 class="text-white font-bold text-lg tracking-wide" style="font-family:'Acme',sans-serif;">Admin Login</h4>
            <button onclick="closeLoginViewer()" class="absolute top-3 right-4 text-white/70 hover:text-white text-2xl leading-none">&times;</button>
        </div>
        <!-- Form -->
        <div class="p-6">
            <form action="/login" method="post" onsubmit="return submitLoginform()">
                <div class="flex flex-col gap-5">
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider" for="l-email">Email</label>
                        <input type="email" name="email" id="l-email" required
                            class="border-b-2 border-amber-400 focus:border-red-800 outline-none py-2 text-sm text-gray-700 transition" />
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider" for="l-password">Password</label>
                        <input type="password" name="password" id="l-password" required
                            class="border-b-2 border-amber-400 focus:border-red-800 outline-none py-2 text-sm text-gray-700 transition" />
                    </div>
                    <button type="submit" id="login-submit" name="submit"
                        class="bg-red-800 hover:bg-red-700 text-white font-bold py-3 rounded-xl transition text-sm tracking-wide">
                        Login
                    </button>
                    <button style="display:none;" id="login-submiting" disabled
                        class="bg-red-400 text-white font-bold py-3 rounded-xl text-sm">
                        Logging in...
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function submitLoginform() {
        document.getElementById('login-submit').style.display = 'none';
        document.getElementById('login-submiting').style.display = 'block';
        return true;
    }
</script>