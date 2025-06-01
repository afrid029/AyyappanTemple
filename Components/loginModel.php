   <!-- Login Model -->
    <div id="login-model" class="model-overlay">
        <div class="model-body">
            
            <div class="model-content">
                <div class="login-form">
                    <div class="login-title">
                        <div onclick="closeLoginViewer()" class="close-btn">Close</div>
                        <h4>Login</h4>
                        <hr>
                    </div>
                    <div class="login-content">
                        <form action="/login" method="post"
                            onsubmit="return submitLoginform()">
                            <div class="Form">
                                <div class="FormRow">
                                    <label htmlFor="email">Email</label>
                                    <input type="email" name="email" id="email" required />
                                </div>
                                <div class="FormRow">
                                    <label htmlFor="password">Password</label>
                                    <input type="password" name="password" id="password" required />
                                </div>

                                <button type="submit" id="login-submit" name="submit"  class="upload"> Login
                                </button>

                                <button style="display: none;" id="login-submiting" disabled="true" class="upload"> logging
                                    in...
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        function submitLoginform() {
        let button = document.getElementById('login-submit');
        let button2 = document.getElementById('login-submiting');
        button.style.display = 'none';
        button2.style.display = 'block';
        return true;
    }
    </script>

    