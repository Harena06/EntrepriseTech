    <!-- CSS FullCalendar -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">

    <style>
        #calendar {
            width: 100%;
        }
    </style>
    <section id="page-mon-calendrier" style="margin-top:3rem">
        <div class="app-wrap">
            <?php echo view('employe/Sidebar', ['active' => $active ?? 'calendar']); ?>

            <div class="main">
                <div class="topbar">
                    <div>
                        <div class="topbar-title">Mon calendrier</div>
                        <div class="topbar-breadcrumb"><a href="#page-dashboard-employe">Accueil</a> <i class="bi bi-chevron-right" style="font-size:.6rem"></i> Mon calendrier</div>
                    </div>
                </div>

                <div class="content">
                    <div id="calendar"></div>
                </div>
            </div>
        </div>
    </section>

    <!-- JS FullCalendar -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const calendarEl = document.getElementById('calendar');

            const calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'fr',

                headerToolbar: {
                    left: 'prev,next today',
                    center: 'title',
                    right: 'dayGridMonth,timeGridWeek,timeGridDay'
                },

                events: [
                    <?php foreach($conges as $conge): ?>
                    {
                        title: '<?= esc($conge['libelle']) ?>',
                        start: '<?= esc($conge['date_debut']) ?>',
                        end: '<?= esc($conge['date_fin']) ?>',
                        color: '<?= $conge['statut'] === 'approuve' ? '#28a745' : ($conge['statut'] === 'en_attente' ? '#ffc107' : '#dc3545') ?>'
                    },
                    <?php endforeach; ?>
                ]
            });

            calendar.render();
        });
    </script>

