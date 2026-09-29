 <script src="https://cdn.jsdelivr.net/npm/overlayscrollbars@2.11.0/browser/overlayscrollbars.browser.es6.min.js"
     crossorigin="anonymous"></script>
 <!--end::Third Party Plugin(OverlayScrollbars)--><!--begin::Required Plugin(popperjs for Bootstrap 5)-->
 <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" crossorigin="anonymous">
 </script>
 <!--end::Required Plugin(AdminLTE)--><!--begin::OverlayScrollbars Configure-->
 <script>
     const SELECTOR_SIDEBAR_WRAPPER = '.sidebar-wrapper';
     const Default = {
         scrollbarTheme: 'os-theme-light',
         scrollbarAutoHide: 'leave',
         scrollbarClickScroll: true,
     };
     document.addEventListener('DOMContentLoaded', function() {
         const sidebarWrapper = document.querySelector(SELECTOR_SIDEBAR_WRAPPER);

         // Disable OverlayScrollbars on mobile devices to prevent touch interference
         const isMobile = window.innerWidth <= 992;

         if (
             sidebarWrapper &&
             OverlayScrollbarsGlobal?.OverlayScrollbars !== undefined &&
             !isMobile
         ) {
             OverlayScrollbarsGlobal.OverlayScrollbars(sidebarWrapper, {
                 scrollbars: {
                     theme: Default.scrollbarTheme,
                     autoHide: Default.scrollbarAutoHide,
                     clickScroll: Default.scrollbarClickScroll,
                 },
             });
         }
     });
 </script>
 <!--end::OverlayScrollbars Configure--><!--begin::Color Mode Toggle (#6010)-->
 <script>
     (() => {
         'use strict';

         const STORAGE_KEY = 'lte-theme';

         const getStoredTheme = () => localStorage.getItem(STORAGE_KEY);
         const setStoredTheme = (theme) => localStorage.setItem(STORAGE_KEY, theme);

         const prefersDark = () => globalThis.matchMedia('(prefers-color-scheme: dark)').matches;

         const getPreferredTheme = () => {
             const stored = getStoredTheme();
             if (stored) return stored;
             return prefersDark() ? 'dark' : 'light';
         };

         const setTheme = (theme) => {
             const resolved = theme === 'auto' ? (prefersDark() ? 'dark' : 'light') : theme;
             document.documentElement.setAttribute('data-bs-theme', resolved);
         };

         setTheme(getPreferredTheme());

         const showActiveTheme = (theme) => {
             // Highlight the active dropdown option
             document.querySelectorAll('[data-bs-theme-value]').forEach((el) => {
                 el.classList.remove('active');
                 el.setAttribute('aria-pressed', 'false');
                 const check = el.querySelector('.bi-check-lg');
                 if (check) check.classList.add('d-none');
             });
             const active = document.querySelector(`[data-bs-theme-value="${theme}"]`);
             if (active) {
                 active.classList.add('active');
                 active.setAttribute('aria-pressed', 'true');
                 const check = active.querySelector('.bi-check-lg');
                 if (check) check.classList.remove('d-none');
             }
             // Sync the topbar trigger icon
             document.querySelectorAll('[data-lte-theme-icon]').forEach((icon) => {
                 icon.classList.toggle('d-none', icon.dataset.lteThemeIcon !== theme);
             });
         };

         globalThis.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', () => {
             const stored = getStoredTheme();
             if (!stored || stored === 'auto') setTheme(getPreferredTheme());
         });

         document.addEventListener('DOMContentLoaded', () => {
             showActiveTheme(getPreferredTheme());
             document.querySelectorAll('[data-bs-theme-value]').forEach((toggle) => {
                 toggle.addEventListener('click', () => {
                     const theme = toggle.getAttribute('data-bs-theme-value');
                     setStoredTheme(theme);
                     setTheme(theme);
                     showActiveTheme(theme);
                 });
             });
         });
     })();
 </script>
 <!--end::Color Mode Toggle-->


 {{-- <script>
     // The Calender
     $('#calendar').datetimepicker({
         format: 'L',
         inline: true
     });
 </script> --}}
 <script>
     //  $(function() {
     //      bsCustomFileInput.init();
     //  });

     @if (Session::get('success'))
         Swal.fire({
             title: "Success",
             text: "{{ Session::get('success') }}",
             icon: "success",
             confirmButtonColor: "#28a745",
         });
     @endif

     @if (Session::get('error'))
         Swal.fire({
             title: "Error",
             text: "{{ Session::get('error') }}",
             icon: "error",
             confirmButtonColor: "#28a745",
         });
     @endif
 </script>
 <script>
     function delData(id, route) {
         document.getElementById('delForm').setAttribute('action', route);

         Swal.fire({
             title: "Are you sure?",
             text: "You won't be able to revert this!",
             icon: "warning",
             showCancelButton: true,
             confirmButtonColor: "#d33",
             cancelButtonColor: "#888",
             confirmButtonText: "Yes, delete it!"
         }).then((result) => {
             if (result.isConfirmed) {
                 document.getElementById('delForm').requestSubmit();
             }
         });
     }

     function activateUser(id, route) {
         document.getElementById('activateUser').setAttribute('action', route);
         document.getElementById('activateUser').requestSubmit();
     }
 </script>

 <script src="https://cdn.jsdelivr.net/npm/tom-select@2.6.1/dist/js/tom-select.complete.min.js"
     integrity="sha384-OgdLxftmuTHirLYFRbvXsKJxgSVqpU4ZdZ07tRiBC+Z4GjtQ5Al0uika0gtMfeQw" crossorigin="anonymous">
 </script>
 <script src="https://cdn.jsdelivr.net/npm/flatpickr@4.6.13/dist/flatpickr.min.js"
     integrity="sha384-5JqMv4L/Xa0hfvtF06qboNdhvuYXUku9ZrhZh3bSk8VXF0A/RuSLHpLsSV9Zqhl6" crossorigin="anonymous">
 </script>

 <script>
     document.addEventListener('DOMContentLoaded', () => {
         // Tom Select: single select with search and a clear button
         const allSelectElements = document.querySelectorAll(".select");
         allSelectElements.forEach(element => {
             new TomSelect(element, {
                 plugins: ['clear_button'],
                 sortField: {
                     field: 'text',
                     direction: 'asc'
                 },
             });
         });

         // Tom Select: multi-select with removable tags (type to add new ones)
         const allMultipleSelectElement = document.querySelectorAll('.multiple-select');

         allMultipleSelectElement.forEach(element => {
             new TomSelect(element, {
                 plugins: ['remove_button'],
                 create: true,
                 persist: false,
             });
         });
     });

     // BS-Stepper Init
     // document.addEventListener('DOMContentLoaded', function() {
     //     window.stepper = new Stepper(document.querySelector('.bs-stepper'))
     // })
     // })
 </script>
