<?php SESSION_START() ?>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="Assets/Images/logo.jpeg" />
    <title> Sri Hariharasudhan Ayyappan Temple</title>
    <meta charset="UTF-8">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Anek+Tamil:wght@100..800&family=Mukta+Malar:wght@200;300;400;500;600;700;800&family=Roboto:ital,wght@0,100..900;1,100..900&display=swap"
        rel="stylesheet">

    <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=arrow_circle_left" />

<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&icon_names=arrow_circle_right" /> -->

    <!-- <link rel="stylesheet" href="/Assets/CSS/index.css"> -->
    <!-- <link rel="stylesheet" href="/Assets/CSS/Form.css">
    <link rel="stylesheet" href="/Assets/CSS/alert.css"> !-->
    <!-- <link rel="stylesheet" href="/Assets/CSS/pagination.css"> -->
    <link rel="stylesheet" href="/Assets/CSS/model.css">
    <link rel="stylesheet" href="/Assets/CSS/dashboard.css">
    <link rel="stylesheet" href="/Assets/CSS/login.css">
    <link rel="stylesheet" href="/Assets/CSS/alert.css">
    <link rel="stylesheet" href="/Assets/CSS/DeleteModel.css">
    <link rel="stylesheet" href="/Assets/CSS/user.css">
    <link rel="stylesheet" href="/Assets/CSS/Form.css">

</head>
<nav class="bg-red-900">
    <div class="nav-bg"></div>
    <div class="mx-auto">
        <div class="relative flex h-25 items-center justify-between flxdir">
            <div class="nav-container">
                <div class="nav-content">
                    <h3> Sri Hariharasudhan Ayyappan Temple Dashboard</h3>
                </div>
            </div>
            <div class="logout">

                <a href="/logout">Logout</a>
            </div>

        </div>
    </div>
</nav>

<body>

    <?php
    
    if (isset($_SESSION['fromAction']) && $_SESSION['fromAction'] === true) { ?>

    <div class="alert-container" id="alertSecond">
        <div class="alert" id="alertContSecond">
            <p><?php echo $_SESSION['message'] ?></p>
        </div>
    </div>

    <?php
        if ($_SESSION['status'] === true) {
            echo "<script>document.getElementById('alertContSecond').style.backgroundColor = '#1D7524';</script>";
        } else {
            echo "<script>document.getElementById('alertContSecond').style.backgroundColor = '#E44C4C';</script>";
        }
        ?>
    <script>
        document.getElementById('alertSecond').style.display = 'flex';
        console.log('Alert triggerdd');
        setTimeout(() => {
            document.getElementById('alertSecond').style.display = 'none';
        }, 7000);
    </script>
    <?php
    }
    $_SESSION['fromAction'] = false;

    if (!isset($_COOKIE['user'])) {
        header('Location: /');
        echo "<script>window.location.pathname = '/'</script>";
        exit();
    } else {

        $data = base64_decode($_COOKIE['user']);

        // Extract the IV (the first 16 bytes)
        $iv = substr($data, 0, 16);

        // Extract the encrypted email (the rest of the string)
        $encryptedData = substr($data, 16);
        $key = 'i3vWrGxR4KiBaKfPbqwnb8U7KjN4MGvq0duG2dXs/Xc=';
        // Decrypt the email using AES-256-CBC decryption
        $decryptedData = openssl_decrypt($encryptedData, 'aes-256-cbc', $key, 0, $iv);

        // $query = "SELECT * from users where email = '$decryptedEmail'";
        $passedArray = unserialize($decryptedData);
        // $result = mysqli_query($db, $query);

            $_SESSION['email'] = $passedArray['email'];
            $_SESSION['role'] = $passedArray['role'];
       
    }

    ?>

    <div class="add-buttons">
        <div onclick="handleModel('event-model', true)" class="createBtn">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#FFFFFF">
                <path d="M427-427H180.78v-106H427v-246.22h106V-533h246.22v106H533v246.22H427V-427Z" /></svg> &nbsp;
            Event
        </div>

        <?php
            if($_SESSION['role'] === 'superadmin') { ?>
        <div onclick="handleModel('user-model', true)" class="createBtn">
            <svg xmlns="http://www.w3.org/2000/svg" height="24px" viewBox="0 -960 960 960" width="24px" fill="#FFFFFF">
                <path d="M427-427H180.78v-106H427v-246.22h106V-533h246.22v106H533v246.22H427V-427Z" /></svg> &nbsp;
            Admin
        </div> <?php
            }
      ?>

    </div>
    <!-- Alert -->
    <div class="alert-container" id="alert">
        <div class="alert" id="alertCont">
            <p id="alert-text"></p>
        </div>

    </div>

    <!-- Add Event -->
    <div id="event-model" class="model-overlay">
        <div class="model-body">
            <div class="model-content">
                <div class="login-form">
                    <div onclick="handleModel('event-model', false)" class="close-btn">x</div>
                    <div class="login-title">
                        <h4>Create Upcoming Event</h4>
                        <hr>
                    </div>
                    <div class="login-content">
                        <form id="add-event-form" method="post" oninput="validateEventForm()">
                            <div class="Form">
                                <div class="FormRow">
                                    <label htmlFor="title">Title</label>
                                    <input type="text" name="title" id="title" required />
                                </div>
                                <div class="FormRow">
                                    <label htmlFor="description">Description</label>
                                    <textarea type="textarea" name="description" id="description" required></textarea>
                                </div>
                                <div class="FormRow">
                                    <label htmlFor="date">Date</label>
                                    <input type="date" name="date" id="date" required></input>
                                </div>
                                <div class="FormRow">
                                    <label htmlFor="time">Time</label>
                                    <input type="time" name="time" id="time" required></input>
                                </div>

                                <button type="submit" id="event-submit" name="submit" disabled="true" class="upload">
                                    Create
                                </button>

                                <button style="display: none;" id="event-submiting" disabled="true" class="upload">
                                    Creating...
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Edit Event -->
    <div id="edit-event-model" class="model-overlay">
        <div class="model-body">
            <div class="model-content">
                <div class="login-form">
                    <div onclick="handleModel('edit-event-model', false)" class="close-btn">x</div>
                    <div class="login-title">
                        <h4>Edit Event</h4>
                        <hr>
                    </div>
                    <div class="login-content">
                        <form id="edit-event-form" method="post" oninput="validateEditEventForm()">
                            <input type="text" name="event-id" id="event-id" hidden>
                            <div class="Form">
                                <div class="FormRow">
                                    <label htmlFor="edit-title">Title</label>
                                    <input type="text" name="edit-title" id="edit-title" required />
                                </div>
                                <div class="FormRow">
                                    <label htmlFor="edit-description">Description</label>
                                    <textarea type="textarea" name="edit-description" id="edit-description"
                                        required></textarea>
                                </div>
                                <div class="FormRow">
                                    <label htmlFor="edit-date">Date</label>
                                    <input type="date" name="edit-date" id="edit-date" required></input>
                                </div>
                                <div class="FormRow">
                                    <label htmlFor="edit-time">Time</label>
                                    <input type="time" name="edit-time" id="edit-time" required></input>
                                </div>

                                <button type="submit" id="edit-event-submit" name="submit" disabled="true"
                                    class="upload">
                                    Update
                                </button>

                                <button style="display: none;" id="edit-event-submiting" disabled="true" class="upload">
                                    Updating...
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- Delete Event -->
    <div class="del-modal-overlay" id="deleteEventModel">
        <div class="del-modal-content" onclick="event.stopPropagation()">

            <form id="delete-event-form" method="post" class="del-form">
                <input type="text" hidden name='ID' id='del-event-id'>
                <div class="delMsg">
                    <h4>Do you want to delete this Event ?</h4>
                </div>
                <div class="option-btn ">
                    <button onclick="handleModel('deleteEventModel', false)" class="opt no" type="button">No</button>
                    <button name="del-submit" class="opt yes" id="del-event-submit" type="submit">Yes</button>
                    <button style="display: none;" id="del-event-submiting" disabled="true" class="opt yes"> Yes
                    </button>
                </div>

            </form>
        </div>
    </div>

    <!-- Add User -->
    <div id="user-model" class="model-overlay">
        <div class="model-body">
            <div class="model-content">
                <div class="login-form">
                    <div onclick="handleModel('user-model', false)" class="close-btn">x</div>
                    <div class="login-title">
                        <h4>Create Admin</h4>
                        <hr>
                    </div>
                    <div class="login-content">
                        <form id="add-user-form" method="post" oninput="validateUserForm()">
                            <div class="Form">
                                <div class="FormRow">
                                    <label htmlFor="email">Email</label>
                                    <input type="email" name="email" id="email" required />
                                </div>
                                <div class="FormRow">
                                    <label htmlFor="password">Password</label>
                                    <input type="text" name="password" id="password" required></input>
                                </div>

                                <button type="submit" id="user-submit" name="submit" disabled="true" class="upload">
                                    Create
                                </button>

                                <button style="display: none;" id="user-submiting" disabled="true" class="upload">
                                    Creating...
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- edit User -->
    <div id="edit-user-model" class="model-overlay">
        <div class="model-body">
            <div class="model-content">
                <div class="login-form">
                    <div onclick="handleModel('edit-user-model', false)" class="close-btn">x</div>
                    <div class="login-title">
                        <h4>Edit Admin</h4>
                        <hr>
                    </div>
                    <div class="login-content">
                        <form id="edit-user-form" method="post" oninput="validateEditUserForm()">
                            <div class="Form">
                                <input type="text" name="user-id" id="user-id" hidden>
                                <div class="FormRow">
                                    <label htmlFor="edit-email">Email</label>
                                    <input type="email" name="email" id="edit-email" required />
                                </div>
                                <div class="FormRow">
                                    <label htmlFor="edit-password">Password</label>
                                    <input type="text" name="password" id="edit-password" required></input>
                                </div>
                                <div class="FormRow active-selection">
                                    <label for="form-active">Active</label>
                                    <input type="radio" name="status" id="form-active">
                                </div>
                                <div class="FormRow active-selection">
                                    <label for="form-deactive">Deactive</label>
                                    <input type="radio" name="status" id="form-deactive">
                                </div>

                                <button type="submit" id="edit-user-submit" name="submit" disabled="true"
                                    class="upload">
                                    Update
                                </button>

                                <button style="display: none;" id="edit-user-submiting" disabled="true" class="upload">
                                    Updating...
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <!-- View Events -->
    <div class="event-viewer">
        <div class="event-viewer-title">
            <h2 class="event-ttl">Events</h2>
            <hr>
        </div>
        <div id="loading-spinner" class="loading-spinner"></div>
        <div id="event-viewer-content" class="event-viewer-content">

        </div>

    </div>

    <!-- View User -->

    <?php
            if($_SESSION['role'] === 'superadmin') { ?>

    <div class="event-viewer">
        <div class="event-viewer-title">
            <h2 class="event-ttl">Users</h2>
            <hr>
        </div>
        <div id="user-loading-spinner" class="loading-spinner"></div>
        <div id="user-viewer-content" class="event-viewer-content">

        </div>

        <?php
            }
      ?>

</body>

</html>

<script>
    function handleModel(ID, status) {
        const model = document.getElementById(ID);
        if (status) {
            model.style.display = "block";
        } else {
            model.style.display = "none";
        }
    }
    // Add Event
    function validateEventForm() {
        const title = document.getElementById("title").value;
        const description = document.getElementById("description").value;
        const date = document.getElementById("date").value;
        const time = document.getElementById("time").value;
        const submit = document.getElementById("event-submit");
        // const submiting = document.getElementById("event-submiting");
        if (title && description && date && time) {
            submit.disabled = false;
        } else {
            submit.disabled = true;
        }
    }
    document.getElementById("add-event-form").addEventListener("submit", function(event) {
        const submit = document.getElementById("event-submit");
        const submiting = document.getElementById("event-submiting");
        submit.style.display = "none";
        submiting.style.display = "block";
        event.preventDefault(); // Prevent the default form submission
        const form = document.getElementById("add-event-form");
        const formData = new FormData(form); // Create a FormData object from the form
        formData.append('submit', true);
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "Controllers/AddEvent.php", true); // Adjust the URL to your PHP script
        xhr.onload = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.status) {
                    alertRise(true, response.message)
                    handleModel('event-model', false);
                    form.reset();
                    validateEventForm();
                    loadEvent();
                    // navigate(1);
                } else {
                    alertRise(false, response.message)
                }
            } else {
                console.log("Error in XMLHttpRequest ", xhr.readyState);
            }
            submit.style.display = "block";
            submiting.style.display = "none";
        }
        xhr.send(formData);
    })
    //Edit Event
    function EditEvent(data) {
        document.getElementById("event-id").value = data.ID
        document.getElementById("edit-title").value = data.title
        document.getElementById("edit-description").value = data.description
        document.getElementById("edit-date").value = data.date
        document.getElementById("edit-time").value = data.time
        validateEditEventForm();
        handleModel('edit-event-model', true);
    }

    function validateEditEventForm() {
        const title = document.getElementById("edit-title").value;
        const description = document.getElementById("edit-description").value;
        const date = document.getElementById("edit-date").value;
        const time = document.getElementById("edit-time").value;
        const submit = document.getElementById("edit-event-submit");
        // const submiting = document.getElementById("event-submiting");
        if (title && description && date && time) {
            submit.disabled = false;
        } else {
            submit.disabled = true;
        }
    }
    document.getElementById("edit-event-form").addEventListener("submit", function(event) {
        const submit = document.getElementById("edit-event-submit");
        const submiting = document.getElementById("edit-event-submiting");
        submit.style.display = "none";
        submiting.style.display = "block";
        event.preventDefault(); // Prevent the default form submission
        const form = document.getElementById("edit-event-form");
        const formData = new FormData(form); // Create a FormData object from the form
        formData.append('edit-submit', true);
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "Controllers/AddEvent.php", true); // Adjust the URL to your PHP script
        xhr.onload = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.status) {
                    alertRise(true, response.message)
                    handleModel('edit-event-model', false);
                    form.reset();
                    validateEditEventForm();
                    loadEvent();
                    // navigate(1);
                } else {
                    alertRise(false, response.message)
                }
            } else {
                console.log("Error in XMLHttpRequest ", xhr.readyState);
            }
            submit.style.display = "block";
            submiting.style.display = "none";
        }
        xhr.send(formData);
    })
    //Delete Event
    function DeleteEvent(data) {
        document.getElementById('del-event-id').value = data.ID;
        handleModel('deleteEventModel', true)
    }
    document.getElementById('delete-event-form').addEventListener('submit', function(event) {
        event.preventDefault();
        const submit = document.getElementById('del-event-submit');
        const submiting = document.getElementById('del-event-submiting');
        submit.style.display = 'none';
        submiting.style.display = 'block';
        // const id =  document.getElementById('del-event-id').value;
        const form = document.getElementById('delete-event-form');
        const formData = new FormData(form);
        formData.append('del-submit', true);
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '/Controllers/AddEvent.php', true);
        xhr.onload = function() {
            if (xhr.status == 200 && xhr.readyState == 4) {
                var response = JSON.parse(xhr.responseText);
                if (xhr.status) {
                    alertRise(true, response.message);
                    handleModel('deleteEventModel', false);
                    loadEvent();
                } else {
                    alertRise(false, response.message);
                }
            } else {
                console.log('XHR Error', xhr.status);
            }
            submit.style.display = 'block';
            submiting.style.display = 'none';
        }
        xhr.send(formData);
    })
    // Add User
    function validateUserForm() {
        const email = document.getElementById("email").value;
        const password = document.getElementById("password").value;
        const submit = document.getElementById("user-submit");
        // const submiting = document.getElementById("event-submiting");
        if (email && password) {
            submit.disabled = false;
        } else {
            submit.disabled = true;
        }
    }
    document.getElementById("add-user-form").addEventListener("submit", function(event) {
        const submit = document.getElementById("user-submit");
        const submiting = document.getElementById("user-submiting");
        submit.style.display = "none";
        submiting.style.display = "block";
        event.preventDefault(); // Prevent the default form submission
        const form = document.getElementById("add-user-form");
        const formData = new FormData(form); // Create a FormData object from the form
        formData.append('submit', true);
        const xhr = new XMLHttpRequest();
        xhr.open("POST", "Controllers/AddUser.php", true); // Adjust the URL to your PHP script
        xhr.onload = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.status) {
                    alertRise(true, response.message)
                    handleModel('user-model', false);
                    form.reset();
                    validateUserForm();
                    loadEvent();
                    // navigate(1);
                } else {
                    alertRise(false, response.message)
                }
            } else {
                console.log("Error in XMLHttpRequest ", xhr.readyState);
            }
            submit.style.display = "block";
            submiting.style.display = "none";
        }
        xhr.send(formData);
    })
    // Edit User
    function EditUser(data) {
        // console.log(data);
        document.getElementById('user-id').value = data.ID;
        document.getElementById('edit-email').value = data.email;
        document.getElementById('edit-password').value = data.password;
        if (data.status == true) {
            document.getElementById('form-active').checked = true;
        } else {
            document.getElementById('form-deactive').checked = true;
        }
        validateEditUserForm()
        handleModel('edit-user-model', true);
    }

    function validateEditUserForm() {
        const email = document.getElementById("edit-email").value.length;
        const password = document.getElementById("edit-password").value.length;
        const btn = document.getElementById("edit-user-submit");
        if (email > 0 && password > 0) {
            btn.disabled = false;
        } else {
            btn.disabled = true;
        }
    }
    document.getElementById('edit-user-form').addEventListener('submit', function(event) {
        let button = document.getElementById('edit-user-submit');
        let button2 = document.getElementById('edit-user-submiting');
        button.style.display = 'none';
        button2.style.display = 'block';
        event.preventDefault();
        const formData = new FormData;
        const userid = document.getElementById('user-id').value;
        const password = document.getElementById('edit-password').value;
        const email = document.getElementById('edit-email').value;
        const status = document.getElementById('form-active').checked ? true : false;
        formData.append('userid', userid);
        formData.append('email', email);
        formData.append('password', password);
        formData.append('active', status);
        formData.append('edit-submit', true);
        const xhr = new XMLHttpRequest();
        xhr.open('POST', '/Controllers/AddUser.php', true);
        xhr.onload = function() {
            if (xhr.status == 200) {
                const data = JSON.parse(xhr.responseText)
                button.style.display = 'block';
                button2.style.display = 'none';
                handleModel('edit-user-model', false)
                alertRise(data.status, data.message)
                loadEvent();
                validateEditUserForm();
            } else {
                console.error('Error submitting form ', xhr.statusText);
            }
        };
        xhr.send(formData);
        // 
    })
    //ON load handles.
    function loadEvent() {
        var xhr = new XMLHttpRequest();
        xhr.open('GET', '/Controllers/GetAllEvents.php', true);
        document.getElementById('loading-spinner').style.display = 'block';
        // document.getElementById('user-loading-spinner').style.display = 'block';
        // const onload = document.getElementById('onrowload');
        // onload.classList.add('onrowload');
        xhr.onreadystatechange = function() {
            if (xhr.readyState == 4 && xhr.status == 200) {
                document.getElementById('loading-spinner').style.display = 'none';
                // document.getElementById('user-loading-spinner').style.display = 'none';
                // document.getElementById('onrowload').style.display = 'none';
                // onload.classList.remove('onrowload');
                var response = JSON.parse(xhr.responseText);
                const dataContainer = document.getElementById('event-viewer-content')
                // const userContainer = document.getElementById('user-viewer-content')

                if(document.getElementById('user-viewer-content')) {
                    const userContainer = document.getElementById('user-viewer-content')
                    userContainer.innerHTML = response.userHtml;
                     document.getElementById('user-loading-spinner').style.display = 'none';
                }
                dataContainer.innerHTML = response.html;
                
                // resizeWindow();
                // dataContainer.classList.remove('fade-in'); // Remove the class to reset animation
                // void dataContainer.offsetWidth; // Trigger reflow
                // dataContainer.classList.add('fade-in'); // Apply fade-in animation
                // document.getElementById('table-pagi').innerHTML = response.pagination;
                // if (page === 1) {
                //     // document.getElementById('count').textContent = "From " + response.total + " donations";
                //     DisplayNumber(response.total, 'current')
                // }
            }
        };
        xhr.send();
    }
    // Load the first page initially
    window.onload = function() {
        loadEvent();
    };
    //Alert Raise
    function alertRise(status, message) {
        document.getElementById('alert-text').innerText = message;
        if (status) {
            document.getElementById('alertCont').style.backgroundColor = '#1D7524';
        } else {
            document.getElementById('alertCont').style.backgroundColor = '#E44C4C';
        }
        setTimeout(() => {
            document.getElementById('alert').style.display = 'flex';
        }, 1000);
        setTimeout(() => {
            document.getElementById('alert').style.display = 'none';
        }, 6000);
    }
</script>