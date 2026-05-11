<?php SESSION_START() ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" type="image/png" href="Assets/Images/logo.jpeg" />
    <title>Sri Hariharasudhan Ayyappan Temple – Dashboard</title>
    <meta charset="UTF-8">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <link href="https://fonts.googleapis.com/css2?family=Acme&family=Mukta+Malar:wght@400;600;700&family=Titillium+Web:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/Assets/CSS/alert.css">
    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: 'Titillium Web', sans-serif;
            background-color: #fdf6ec;
        }

        input,
        textarea,
        select {
            text-transform: none;
        }

        input[type="file"] {
            padding: 4px 0;
        }

        /* Spinner */
        .spinner {
            width: 36px;
            height: 36px;
            border: 4px solid #f3f3f3;
            border-top: 4px solid #7f1d1d;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            margin: 20px auto;
            display: none;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        /* Modal overlay */
        .modal-overlay {
            position: fixed;
            inset: 0;
            z-index: 50;
            background: rgba(0, 0, 0, 0.55);
            backdrop-filter: blur(3px);
            display: none;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }

        .modal-overlay.active {
            display: flex;
        }

        /* Delete modal */
        .del-modal-overlay {
            position: fixed;
            inset: 0;
            z-index: 60;
            background: rgba(0, 0, 0, 0.5);
            display: none;
            align-items: center;
            justify-content: center;
            padding: 16px;
        }

        .del-modal-overlay.active {
            display: flex;
        }
    </style>
</head>

<body class="min-h-screen">

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
            setTimeout(() => {
                document.getElementById('alertSecond').style.display = 'none';
            }, 7000);
        </script>
    <?php }
    $_SESSION['fromAction'] = false;

    if (!isset($_COOKIE['user'])) {
        header('Location: /');
        echo "<script>window.location.pathname='/'</script>";
        exit();
    } else {
        $data = base64_decode($_COOKIE['user']);
        $iv = substr($data, 0, 16);
        $encryptedData = substr($data, 16);
        $key = 'i3vWrGxR4KiBaKfPbqwnb8U7KjN4MGvq0duG2dXs/Xc=';
        $decryptedData = openssl_decrypt($encryptedData, 'aes-256-cbc', $key, 0, $iv);
        $passedArray = unserialize($decryptedData);
        $_SESSION['email'] = $passedArray['email'];
        $_SESSION['role'] = $passedArray['role'];
    }
    ?>

    <!-- NAVBAR -->
    <nav class="bg-red-900 shadow-lg sticky top-0 z-40">
        <div class="max-w-7xl mx-auto px-4 py-4 flex flex-col sm:flex-row items-center justify-between gap-2">
            <div class="text-center sm:text-left">
                <h1 class="text-white font-bold text-lg md:text-2xl tracking-wide" style="font-family:'Acme',sans-serif;">
                    Sri Hariharasudhan Ayyappan Temple
                </h1>
                <p class="text-red-300 text-xs tracking-widest uppercase">Dashboard</p>
            </div>
            <div class="flex items-center gap-3">
                <span class="text-red-200 text-sm hidden sm:block"><?php echo htmlspecialchars($_SESSION['email']); ?></span>
                <a href="/logout" class="bg-white text-red-900 hover:bg-red-50 font-semibold text-sm px-4 py-2 rounded-lg transition shadow">
                    Logout
                </a>
            </div>
        </div>
    </nav>

    <!-- ALERT (AJAX) -->
    <div class="alert-container" id="alert">
        <div class="alert" id="alertCont">
            <p id="alert-text"></p>
        </div>
    </div>

    <!-- ACTION BUTTONS -->
    <div class="max-w-7xl mx-auto px-4 py-6 flex flex-wrap gap-3 justify-center sm:justify-start">
        <button onclick="handleModel('event-model', true)"
            class="flex items-center gap-2 bg-amber-500 hover:bg-amber-600 text-white font-semibold px-5 py-3 rounded-xl shadow transition text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 -960 960 960" fill="currentColor">
                <path d="M427-427H180.78v-106H427v-246.22h106V-533h246.22v106H533v246.22H427V-427Z" />
            </svg>
            Add Event
        </button>

        <?php if ($_SESSION['role'] === 'superadmin'): ?>
            <button onclick="handleModel('user-model', true)"
                class="flex items-center gap-2 bg-red-800 hover:bg-red-700 text-white font-semibold px-5 py-3 rounded-xl shadow transition text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 -960 960 960" fill="currentColor">
                    <path d="M427-427H180.78v-106H427v-246.22h106V-533h246.22v106H533v246.22H427V-427Z" />
                </svg>
                Add Admin
            </button>
        <?php endif; ?>

        <button onclick="handleModel('notice-model', true)"
            class="flex items-center gap-2 bg-orange-600 hover:bg-orange-500 text-white font-semibold px-5 py-3 rounded-xl shadow transition text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 -960 960 960" fill="currentColor">
                <path d="M427-427H180.78v-106H427v-246.22h106V-533h246.22v106H533v246.22H427V-427Z" />
            </svg>
            Add Notice
        </button>
    </div>

    <!-- MAIN CONTENT -->
    <div class="max-w-7xl mx-auto px-4 pb-10 flex flex-col gap-8">

        <!-- Events Section -->
        <section class="bg-white rounded-2xl shadow p-6">
            <h2 class="text-red-900 font-bold text-xl mb-1" style="font-family:'Acme',sans-serif;">Events</h2>
            <hr class="border-amber-300 mb-4">
            <div id="loading-spinner" class="spinner"></div>
            <div id="event-viewer-content" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4"></div>
        </section>

        <!-- Notices Section -->
        <section class="bg-white rounded-2xl shadow p-6">
            <h2 class="text-red-900 font-bold text-xl mb-1" style="font-family:'Acme',sans-serif;">Notices</h2>
            <hr class="border-amber-300 mb-4">
            <div id="notice-loading-spinner" class="spinner"></div>
            <div id="notice-viewer-content" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4"></div>
        </section>

        <?php if ($_SESSION['role'] === 'superadmin'): ?>
            <!-- Users Section -->
            <section class="bg-white rounded-2xl shadow p-6">
                <h2 class="text-red-900 font-bold text-xl mb-1" style="font-family:'Acme',sans-serif;">Admins</h2>
                <hr class="border-amber-300 mb-4">
                <div id="user-loading-spinner" class="spinner"></div>
                <div id="user-viewer-content" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4"></div>
            </section>
        <?php endif; ?>

    </div>

    <!-- =========================================================
     MODALS
     ========================================================= -->

    <!-- Reusable modal form field macro (PHP helper) -->
    <?php
    function formField($label, $inputHtml)
    {
        echo '<div class="flex flex-col gap-1">
            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">' . $label . '</label>
            ' . $inputHtml . '
          </div>';
    }
    function modalBtn($id, $label, $color = 'red')
    {
        $colors = [
            'red'    => 'bg-red-800 hover:bg-red-700',
            'amber'  => 'bg-amber-500 hover:bg-amber-400',
            'orange' => 'bg-orange-600 hover:bg-orange-500',
        ];
        $cls = $colors[$color] ?? $colors['red'];
        return '<button type="submit" id="' . $id . '" class="' . $cls . ' text-white font-bold py-3 rounded-xl transition text-sm tracking-wide w-full mt-2" disabled>
                ' . $label . '
            </button>
            <button type="button" id="' . $id . 'ing" class="bg-gray-400 text-white font-bold py-3 rounded-xl text-sm w-full mt-2" style="display:none;" disabled>
                Loading...
            </button>';
    }
    ?>

    <!-- ADD EVENT MODAL -->
    <div id="event-model" class="modal-overlay">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden" onclick="event.stopPropagation()">
            <div class="bg-red-900 px-6 py-4 flex items-center justify-between">
                <h3 class="text-white font-bold text-lg" style="font-family:'Acme',sans-serif;">Add Event</h3>
                <button onclick="handleModel('event-model', false)" class="text-white/70 hover:text-white text-2xl leading-none">&times;</button>
            </div>
            <div class="p-6 overflow-y-auto max-h-[80vh]">
                <form id="add-event-form" method="post" oninput="validateEventForm()" class="flex flex-col gap-5">
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Title</label>
                        <input type="text" name="title" id="title" required class="border-b-2 border-amber-300 focus:border-red-800 outline-none py-2 text-sm text-gray-700 transition" />
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Description</label>
                        <textarea name="description" id="description" required class="border-b-2 border-amber-300 focus:border-red-800 outline-none py-2 text-sm text-gray-700 transition resize-none" rows="4"></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1">
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</label>
                            <input type="date" name="date" id="date" required class="border-b-2 border-amber-300 focus:border-red-800 outline-none py-2 text-sm text-gray-700 transition" />
                        </div>
                        <div class="flex flex-col gap-1">
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Time</label>
                            <input type="time" name="time" id="time" required class="border-b-2 border-amber-300 focus:border-red-800 outline-none py-2 text-sm text-gray-700 transition" />
                        </div>
                    </div>
                    <button type="submit" id="event-submit" name="submit" disabled class="bg-red-800 hover:bg-red-700 text-white font-bold py-3 rounded-xl transition text-sm w-full">Create Event</button>
                    <button type="button" id="event-submiting" class="bg-gray-400 text-white font-bold py-3 rounded-xl text-sm w-full" style="display:none;" disabled>Creating...</button>
                </form>
            </div>
        </div>
    </div>

    <!-- EDIT EVENT MODAL -->
    <div id="edit-event-model" class="modal-overlay">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden" onclick="event.stopPropagation()">
            <div class="bg-amber-500 px-6 py-4 flex items-center justify-between">
                <h3 class="text-white font-bold text-lg" style="font-family:'Acme',sans-serif;">Edit Event</h3>
                <button onclick="handleModel('edit-event-model', false)" class="text-white/70 hover:text-white text-2xl leading-none">&times;</button>
            </div>
            <div class="p-6 overflow-y-auto max-h-[80vh]">
                <form id="edit-event-form" method="post" oninput="validateEditEventForm()" class="flex flex-col gap-5">
                    <input type="text" name="event-id" id="event-id" hidden>
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Title</label>
                        <input type="text" name="edit-title" id="edit-title" required class="border-b-2 border-amber-300 focus:border-amber-600 outline-none py-2 text-sm text-gray-700 transition" />
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Description</label>
                        <textarea name="edit-description" id="edit-description" required class="border-b-2 border-amber-300 focus:border-amber-600 outline-none py-2 text-sm text-gray-700 transition resize-none" rows="4"></textarea>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="flex flex-col gap-1">
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</label>
                            <input type="date" name="edit-date" id="edit-date" required class="border-b-2 border-amber-300 focus:border-amber-600 outline-none py-2 text-sm text-gray-700 transition" />
                        </div>
                        <div class="flex flex-col gap-1">
                            <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Time</label>
                            <input type="time" name="edit-time" id="edit-time" required class="border-b-2 border-amber-300 focus:border-amber-600 outline-none py-2 text-sm text-gray-700 transition" />
                        </div>
                    </div>
                    <button type="submit" id="edit-event-submit" name="submit" disabled class="bg-amber-500 hover:bg-amber-400 text-white font-bold py-3 rounded-xl transition text-sm w-full">Update Event</button>
                    <button type="button" id="edit-event-submiting" class="bg-gray-400 text-white font-bold py-3 rounded-xl text-sm w-full" style="display:none;" disabled>Updating...</button>
                </form>
            </div>
        </div>
    </div>

    <!-- DELETE EVENT MODAL -->
    <div class="del-modal-overlay" id="deleteEventModel">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm p-8 flex flex-col gap-6" onclick="event.stopPropagation()">
            <div class="text-center">
                <div class="text-5xl mb-3">🗑️</div>
                <h4 class="text-gray-800 font-bold text-lg">Delete Event?</h4>
                <p class="text-gray-500 text-sm mt-1">This action cannot be undone.</p>
            </div>
            <form id="delete-event-form" method="post" class="flex gap-4">
                <input type="text" hidden name="ID" id="del-event-id">
                <button type="button" onclick="handleModel('deleteEventModel', false)" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 rounded-xl transition text-sm">Cancel</button>
                <button type="submit" name="del-submit" id="del-event-submit" class="flex-1 bg-red-700 hover:bg-red-600 text-white font-semibold py-3 rounded-xl transition text-sm">Delete</button>
                <button type="button" id="del-event-submiting" class="flex-1 bg-red-400 text-white font-semibold py-3 rounded-xl text-sm" style="display:none;" disabled>Deleting...</button>
            </form>
        </div>
    </div>

    <!-- ADD USER MODAL -->
    <div id="user-model" class="modal-overlay">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden" onclick="event.stopPropagation()">
            <div class="bg-red-900 px-6 py-4 flex items-center justify-between">
                <h3 class="text-white font-bold text-lg" style="font-family:'Acme',sans-serif;">Create Admin</h3>
                <button onclick="handleModel('user-model', false)" class="text-white/70 hover:text-white text-2xl leading-none">&times;</button>
            </div>
            <div class="p-6">
                <form id="add-user-form" method="post" oninput="validateUserForm()" class="flex flex-col gap-5">
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Email</label>
                        <input type="email" name="email" id="email" required class="border-b-2 border-amber-300 focus:border-red-800 outline-none py-2 text-sm text-gray-700 transition" />
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Password</label>
                        <input type="password" name="password" id="password" required class="border-b-2 border-amber-300 focus:border-red-800 outline-none py-2 text-sm text-gray-700 transition" />
                    </div>
                    <button type="submit" id="user-submit" name="submit" disabled class="bg-red-800 hover:bg-red-700 text-white font-bold py-3 rounded-xl transition text-sm w-full">Create Admin</button>
                    <button type="button" id="user-submiting" class="bg-gray-400 text-white font-bold py-3 rounded-xl text-sm w-full" style="display:none;" disabled>Creating...</button>
                </form>
            </div>
        </div>
    </div>

    <!-- EDIT USER MODAL -->
    <div id="edit-user-model" class="modal-overlay">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden" onclick="event.stopPropagation()">
            <div class="bg-amber-500 px-6 py-4 flex items-center justify-between">
                <h3 class="text-white font-bold text-lg" style="font-family:'Acme',sans-serif;">Edit Admin</h3>
                <button onclick="handleModel('edit-user-model', false)" class="text-white/70 hover:text-white text-2xl leading-none">&times;</button>
            </div>
            <div class="p-6">
                <form id="edit-user-form" method="post" oninput="validateEditUserForm()" class="flex flex-col gap-5">
                    <input type="text" name="user-id" id="user-id" hidden>
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Email</label>
                        <input type="email" name="email" id="edit-email" required class="border-b-2 border-amber-300 focus:border-amber-600 outline-none py-2 text-sm text-gray-700 transition" />
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">New Password</label>
                        <input type="password" name="password" id="edit-password" placeholder="Leave blank to keep current password" class="border-b-2 border-amber-300 focus:border-amber-600 outline-none py-2 text-sm text-gray-700 transition" />
                    </div>
                    <div class="flex gap-6">
                        <label class="flex items-center gap-2 text-sm font-semibold text-gray-600 cursor-pointer">
                            <input type="radio" name="status" id="form-active" class="accent-green-600"> Active
                        </label>
                        <label class="flex items-center gap-2 text-sm font-semibold text-gray-600 cursor-pointer">
                            <input type="radio" name="status" id="form-deactive" class="accent-red-600"> Disabled
                        </label>
                    </div>
                    <button type="submit" id="edit-user-submit" name="submit" disabled class="bg-amber-500 hover:bg-amber-400 text-white font-bold py-3 rounded-xl transition text-sm w-full">Update Admin</button>
                    <button type="button" id="edit-user-submiting" class="bg-gray-400 text-white font-bold py-3 rounded-xl text-sm w-full" style="display:none;" disabled>Updating...</button>
                </form>
            </div>
        </div>
    </div>

    <!-- ADD NOTICE MODAL -->
    <div id="notice-model" class="modal-overlay">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden" onclick="event.stopPropagation()">
            <div class="bg-orange-600 px-6 py-4 flex items-center justify-between">
                <h3 class="text-white font-bold text-lg" style="font-family:'Acme',sans-serif;">Add Notice</h3>
                <button onclick="handleModel('notice-model', false)" class="text-white/70 hover:text-white text-2xl leading-none">&times;</button>
            </div>
            <div class="p-6 overflow-y-auto max-h-[80vh]">
                <form id="add-notice-form" method="post" oninput="validateAddNoticeForm()" class="flex flex-col gap-5">
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Title</label>
                        <input type="text" name="notice-title" id="notice-title" required class="border-b-2 border-amber-300 focus:border-orange-600 outline-none py-2 text-sm text-gray-700 transition" />
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</label>
                        <input type="date" name="notice-date" id="notice-date" required class="border-b-2 border-amber-300 focus:border-orange-600 outline-none py-2 text-sm text-gray-700 transition" />
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold text-orange-700 uppercase tracking-wider text-sm">Tamil Notice Image</label>
                        <input type="file" accept="image/jpeg,image/png,image/gif,image/jpg" name="tamnotice" id="tamnotice" required class="text-sm text-gray-600 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-orange-100 file:text-orange-700 file:font-semibold hover:file:bg-orange-200" />
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold text-orange-700 uppercase tracking-wider text-sm">English Notice Image</label>
                        <input type="file" accept="image/jpeg,image/png,image/gif,image/jpg" name="engnotice" id="engnotice" required class="text-sm text-gray-600 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-orange-100 file:text-orange-700 file:font-semibold hover:file:bg-orange-200" />
                    </div>
                    <button type="submit" id="add-notice-submit" name="submit" disabled class="bg-orange-600 hover:bg-orange-500 text-white font-bold py-3 rounded-xl transition text-sm w-full">Submit Notice</button>
                    <button type="button" id="add-notice-submiting" class="bg-gray-400 text-white font-bold py-3 rounded-xl text-sm w-full" style="display:none;" disabled>Submitting...</button>
                </form>
            </div>
        </div>
    </div>

    <!-- EDIT NOTICE MODAL -->
    <div id="edit-notice-model" class="modal-overlay">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md overflow-hidden" onclick="event.stopPropagation()">
            <div class="bg-orange-500 px-6 py-4 flex items-center justify-between">
                <h3 class="text-white font-bold text-lg" style="font-family:'Acme',sans-serif;">Edit Notice</h3>
                <button onclick="handleModel('edit-notice-model', false)" class="text-white/70 hover:text-white text-2xl leading-none">&times;</button>
            </div>
            <div class="p-6 overflow-y-auto max-h-[80vh]">
                <form id="edit-notice-form" method="post" oninput="validateEditNoticeForm()" class="flex flex-col gap-5">
                    <input type="text" name="notice-id" id="edit-notice-id" hidden>
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Title</label>
                        <input type="text" name="edit-notice-title" id="edit-notice-title" required class="border-b-2 border-amber-300 focus:border-orange-500 outline-none py-2 text-sm text-gray-700 transition" />
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</label>
                        <input type="date" name="edit-notice-date" id="edit-notice-date" required class="border-b-2 border-amber-300 focus:border-orange-500 outline-none py-2 text-sm text-gray-700 transition" />
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold text-orange-700 uppercase tracking-wider text-sm">Replace Tamil Notice (optional)</label>
                        <input type="file" accept="image/jpeg,image/png,image/gif,image/jpg" name="edit-tamnotice" id="edit-tamnotice" class="text-sm text-gray-600 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-orange-100 file:text-orange-700 file:font-semibold hover:file:bg-orange-200" />
                    </div>
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold text-orange-700 uppercase tracking-wider text-sm">Replace English Notice (optional)</label>
                        <input type="file" accept="image/jpeg,image/png,image/gif,image/jpg" name="edit-engnotice" id="edit-engnotice" class="text-sm text-gray-600 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-orange-100 file:text-orange-700 file:font-semibold hover:file:bg-orange-200" />
                    </div>
                    <button type="submit" id="edit-notice-submit" name="submit" disabled class="bg-orange-500 hover:bg-orange-400 text-white font-bold py-3 rounded-xl transition text-sm w-full">Update Notice</button>
                    <button type="button" id="edit-notice-submiting" class="bg-gray-400 text-white font-bold py-3 rounded-xl text-sm w-full" style="display:none;" disabled>Updating...</button>
                </form>
            </div>
        </div>
    </div>

    <!-- DELETE NOTICE MODAL -->
    <div class="del-modal-overlay" id="deleteNoticeModel">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm p-8 flex flex-col gap-6" onclick="event.stopPropagation()">
            <div class="text-center">
                <div class="text-5xl mb-3">🗑️</div>
                <h4 class="text-gray-800 font-bold text-lg">Delete Notice?</h4>
                <p class="text-gray-500 text-sm mt-1">This action cannot be undone.</p>
            </div>
            <form id="delete-notice-form" method="post" class="flex gap-4">
                <input type="text" hidden name="ID" id="del-notice-id">
                <button type="button" onclick="handleModel('deleteNoticeModel', false)" class="flex-1 bg-gray-100 hover:bg-gray-200 text-gray-700 font-semibold py-3 rounded-xl transition text-sm">Cancel</button>
                <button type="submit" name="del-submit" id="del-notice-submit" class="flex-1 bg-red-700 hover:bg-red-600 text-white font-semibold py-3 rounded-xl transition text-sm">Delete</button>
                <button type="button" id="del-notice-submiting" class="flex-1 bg-red-400 text-white font-semibold py-3 rounded-xl text-sm" style="display:none;" disabled>Deleting...</button>
            </form>
        </div>
    </div>

    <!-- =========================================================
     JAVASCRIPT — all logic preserved exactly
     ========================================================= -->
    <script>
        function handleModel(ID, status) {
            const model = document.getElementById(ID);
            model.style.display = status ? 'flex' : 'none';
        }

        // Add Event
        function validateEventForm() {
            const title = document.getElementById("title").value;
            const description = document.getElementById("description").value;
            const date = document.getElementById("date").value;
            const time = document.getElementById("time").value;
            document.getElementById("event-submit").disabled = !(title && description && date && time);
        }
        document.getElementById("add-event-form").addEventListener("submit", function(event) {
            const submit = document.getElementById("event-submit");
            const submiting = document.getElementById("event-submiting");
            submit.style.display = "none";
            submiting.style.display = "block";
            event.preventDefault();
            const form = document.getElementById("add-event-form");
            const formData = new FormData(form);
            formData.append('submit', true);
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "Controllers/AddEvent.php", true);
            xhr.onload = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.status) {
                        alertRise(true, response.message);
                        handleModel('event-model', false);
                        form.reset();
                        validateEventForm();
                        loadEvent();
                    } else {
                        alertRise(false, response.message);
                    }
                }
                submit.style.display = "block";
                submiting.style.display = "none";
            }
            xhr.send(formData);
        });

        // Edit Event
        function EditEvent(data) {
            document.getElementById("event-id").value = data.ID;
            document.getElementById("edit-title").value = data.title;
            document.getElementById("edit-description").value = data.description;
            document.getElementById("edit-date").value = data.date;
            document.getElementById("edit-time").value = data.time;
            validateEditEventForm();
            handleModel('edit-event-model', true);
        }

        function validateEditEventForm() {
            const title = document.getElementById("edit-title").value;
            const description = document.getElementById("edit-description").value;
            const date = document.getElementById("edit-date").value;
            const time = document.getElementById("edit-time").value;
            document.getElementById("edit-event-submit").disabled = !(title && description && date && time);
        }
        document.getElementById("edit-event-form").addEventListener("submit", function(event) {
            const submit = document.getElementById("edit-event-submit");
            const submiting = document.getElementById("edit-event-submiting");
            submit.style.display = "none";
            submiting.style.display = "block";
            event.preventDefault();
            const form = document.getElementById("edit-event-form");
            const formData = new FormData(form);
            formData.append('edit-submit', true);
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "Controllers/AddEvent.php", true);
            xhr.onload = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.status) {
                        alertRise(true, response.message);
                        handleModel('edit-event-model', false);
                        form.reset();
                        validateEditEventForm();
                        loadEvent();
                    } else {
                        alertRise(false, response.message);
                    }
                }
                submit.style.display = "block";
                submiting.style.display = "none";
            }
            xhr.send(formData);
        });

        // Delete Event
        function DeleteEvent(data) {
            document.getElementById('del-event-id').value = data.ID;
            handleModel('deleteEventModel', true);
        }
        document.getElementById('delete-event-form').addEventListener('submit', function(event) {
            event.preventDefault();
            const submit = document.getElementById('del-event-submit');
            const submiting = document.getElementById('del-event-submiting');
            submit.style.display = 'none';
            submiting.style.display = 'block';
            const form = document.getElementById('delete-event-form');
            const formData = new FormData(form);
            formData.append('del-submit', true);
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '/Controllers/AddEvent.php', true);
            xhr.onload = function() {
                if (xhr.status == 200 && xhr.readyState == 4) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.status) {
                        alertRise(true, response.message);
                        handleModel('deleteEventModel', false);
                        loadEvent();
                    } else {
                        alertRise(false, response.message);
                    }
                }
                submit.style.display = 'block';
                submiting.style.display = 'none';
            }
            xhr.send(formData);
        });

        // Add User
        function validateUserForm() {
            const email = document.getElementById("email").value;
            const password = document.getElementById("password").value;
            document.getElementById("user-submit").disabled = !(email && password);
        }
        document.getElementById("add-user-form").addEventListener("submit", function(event) {
            const submit = document.getElementById("user-submit");
            const submiting = document.getElementById("user-submiting");
            submit.style.display = "none";
            submiting.style.display = "block";
            event.preventDefault();
            const form = document.getElementById("add-user-form");
            const formData = new FormData(form);
            formData.append('submit', true);
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "Controllers/AddUser.php", true);
            xhr.onload = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.status) {
                        alertRise(true, response.message);
                        handleModel('user-model', false);
                        form.reset();
                        validateUserForm();
                        loadEvent();
                    } else {
                        alertRise(false, response.message);
                    }
                }
                submit.style.display = "block";
                submiting.style.display = "none";
            }
            xhr.send(formData);
        });

        // Edit User
        function EditUser(data) {
            document.getElementById('user-id').value = data.ID;
            document.getElementById('edit-email').value = data.email;
            document.getElementById('edit-password').value = '';
            if (data.status == true) {
                document.getElementById('form-active').checked = true;
            } else {
                document.getElementById('form-deactive').checked = true;
            }
            validateEditUserForm();
            handleModel('edit-user-model', true);
        }

        function validateEditUserForm() {
            const email = document.getElementById("edit-email").value.length;
            document.getElementById("edit-user-submit").disabled = !(email > 0);
        }
        document.getElementById('edit-user-form').addEventListener('submit', function(event) {
            let button = document.getElementById('edit-user-submit');
            let button2 = document.getElementById('edit-user-submiting');
            button.style.display = 'none';
            button2.style.display = 'block';
            event.preventDefault();
            const formData = new FormData();
            formData.append('userid', document.getElementById('user-id').value);
            formData.append('email', document.getElementById('edit-email').value);
            formData.append('password', document.getElementById('edit-password').value);
            formData.append('active', document.getElementById('form-active').checked ? true : false);
            formData.append('edit-submit', true);
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '/Controllers/AddUser.php', true);
            xhr.onload = function() {
                if (xhr.status == 200) {
                    const data = JSON.parse(xhr.responseText);
                    button.style.display = 'block';
                    button2.style.display = 'none';
                    handleModel('edit-user-model', false);
                    alertRise(data.status, data.message);
                    loadEvent();
                    validateEditUserForm();
                }
            };
            xhr.send(formData);
        });

        // Load Events + Users
        function loadEvent() {
            document.getElementById('loading-spinner').style.display = 'block';
            const xhr = new XMLHttpRequest();
            xhr.open('GET', '/Controllers/GetAllEvents.php', true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById('loading-spinner').style.display = 'none';
                    var response = JSON.parse(xhr.responseText);
                    document.getElementById('event-viewer-content').innerHTML = response.html;
                    if (document.getElementById('user-viewer-content')) {
                        document.getElementById('user-viewer-content').innerHTML = response.userHtml;
                        document.getElementById('user-loading-spinner').style.display = 'none';
                    }
                }
            };
            xhr.send();
        }

        // Add Notice
        function validateAddNoticeForm() {
            const title = document.getElementById("notice-title").value;
            const date = document.getElementById("notice-date").value;
            const tam = document.getElementById("tamnotice").value;
            const eng = document.getElementById("engnotice").value;
            document.getElementById("add-notice-submit").disabled = !(title && date && tam && eng);
        }
        document.getElementById("add-notice-form").addEventListener("submit", function(event) {
            event.preventDefault();
            const submit = document.getElementById("add-notice-submit");
            const submiting = document.getElementById("add-notice-submiting");
            submit.style.display = "none";
            submiting.style.display = "block";
            const form = document.getElementById("add-notice-form");
            const formData = new FormData(form);
            formData.append('submit', true);
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "Controllers/AddNotice.php", true);
            xhr.onload = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.status) {
                        alertRise(true, response.message);
                        handleModel('notice-model', false);
                        form.reset();
                        validateAddNoticeForm();
                        loadNotices();
                    } else {
                        alertRise(false, response.message);
                    }
                }
                submit.style.display = "block";
                submiting.style.display = "none";
            };
            xhr.send(formData);
        });

        // Edit Notice
        function EditNotice(data) {
            document.getElementById("edit-notice-id").value = data.ID;
            document.getElementById("edit-notice-title").value = data.title;
            document.getElementById("edit-notice-date").value = data.date;
            validateEditNoticeForm();
            handleModel('edit-notice-model', true);
        }

        function validateEditNoticeForm() {
            const title = document.getElementById("edit-notice-title").value;
            const date = document.getElementById("edit-notice-date").value;
            document.getElementById("edit-notice-submit").disabled = !(title && date);
        }
        document.getElementById("edit-notice-form").addEventListener("submit", function(event) {
            event.preventDefault();
            const submit = document.getElementById("edit-notice-submit");
            const submiting = document.getElementById("edit-notice-submiting");
            submit.style.display = "none";
            submiting.style.display = "block";
            const form = document.getElementById("edit-notice-form");
            const formData = new FormData(form);
            formData.append('edit-submit', true);
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "Controllers/AddNotice.php", true);
            xhr.onload = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.status) {
                        alertRise(true, response.message);
                        handleModel('edit-notice-model', false);
                        form.reset();
                        loadNotices();
                    } else {
                        alertRise(false, response.message);
                    }
                }
                submit.style.display = "block";
                submiting.style.display = "none";
            };
            xhr.send(formData);
        });

        // Delete Notice
        function DeleteNotice(data) {
            document.getElementById('del-notice-id').value = data.ID;
            handleModel('deleteNoticeModel', true);
        }
        document.getElementById('delete-notice-form').addEventListener('submit', function(event) {
            event.preventDefault();
            const submit = document.getElementById('del-notice-submit');
            const submiting = document.getElementById('del-notice-submiting');
            submit.style.display = 'none';
            submiting.style.display = 'block';
            const form = document.getElementById('delete-notice-form');
            const formData = new FormData(form);
            formData.append('del-submit', true);
            const xhr = new XMLHttpRequest();
            xhr.open('POST', '/Controllers/AddNotice.php', true);
            xhr.onload = function() {
                if (xhr.status == 200 && xhr.readyState == 4) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.status) {
                        alertRise(true, response.message);
                        handleModel('deleteNoticeModel', false);
                        loadNotices();
                    } else {
                        alertRise(false, response.message);
                    }
                }
                submit.style.display = 'block';
                submiting.style.display = 'none';
            };
            xhr.send(formData);
        });

        // Load Notices
        function loadNotices() {
            document.getElementById('notice-loading-spinner').style.display = 'block';
            const xhr = new XMLHttpRequest();
            xhr.open('GET', '/Controllers/GetAllNotices.php', true);
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    document.getElementById('notice-loading-spinner').style.display = 'none';
                    var response = JSON.parse(xhr.responseText);
                    document.getElementById('notice-viewer-content').innerHTML = response.html;
                }
            };
            xhr.send();
        }

        window.onload = function() {
            loadEvent();
            loadNotices();
        };

        function alertRise(status, message) {
            document.getElementById('alert-text').innerText = message;
            document.getElementById('alertCont').style.backgroundColor = status ? '#1D7524' : '#E44C4C';
            setTimeout(() => {
                document.getElementById('alert').style.display = 'flex';
            }, 300);
            setTimeout(() => {
                document.getElementById('alert').style.display = 'none';
            }, 6000);
        }
    </script>
</body>

</html>