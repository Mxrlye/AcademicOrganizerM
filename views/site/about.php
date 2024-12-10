<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;

$this->title = 'RECORDATORIOS';
?>

<div class="site-about">
    <!-- Botones flotantes -->
    <div class="buttons-container">
        <button class="view-calendar-btn" onclick="toggleCalendar()">🗓️</button>
        <button class="add-event-btn" onclick="openModal()">+</button>
    </div>

    <!-- Calendario -->
    <div class="calendar" id="calendar">
        <div class="calendar-header">
            <button class="nav-arrow" onclick="changeMonth(-1)">←</button>
            <span id="current-month-year">Diciembre 2024</span>
            <button class="nav-arrow" onclick="changeMonth(1)">→</button>
        </div>
        <div class="calendar-days">
            <div>Lunes</div>
            <div>Martes</div>
            <div>Miércoles</div>
            <div>Jueves</div>
            <div>Viernes</div>
            <div>Sábado</div>
            <div>Domingo</div>
        </div>
        <div class="calendar-dates" id="calendar-dates">
            <!-- Los días del mes se renderizan dinámicamente -->
        </div>
    </div>

    <!-- Modal para agregar evento -->
    <div id="addEventModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h3>Agregar Evento</h3>

            <?php $form = ActiveForm::begin([
                'id' => 'event-form',
                'action' => ['site/about'],
                'method' => 'post',
            ]); ?>

            <?= $form->field($eventModel, 'titulo')->textInput(['maxlength' => true, 'placeholder' => 'Título']) ?>
            <?= $form->field($eventModel, 'descripcion')->textarea(['rows' => 2, 'placeholder' => 'Descripción']) ?>
            <?= $form->field($eventModel, 'fecha')->input('date') ?>
            <?= $form->field($eventModel, 'hora_inicio')->input('time') ?>
            <?= $form->field($eventModel, 'hora_fin')->input('time') ?>

            <div class="form-group">
                <?= Html::submitButton('Guardar Evento', ['class' => 'btn btn-success']) ?>
                <button type="button" class="btn btn-secondary" onclick="closeModal()">Cerrar</button>
            </div>

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>

<style>
/* General */
body {
    font-family: Arial, sans-serif;
    margin: 0;
    padding: 0;
}

/* Botones flotantes */
.buttons-container {
    position: fixed;
    right: 20px;
    display: flex;
    flex-direction: column;
    gap: 15px;
    z-index: 1000;
}

.add-event-btn,
.view-calendar-btn {
    width: 60px;
    height: 60px;
    background: #007bff;
    color: white;
    border: none;
    border-radius: 50%;
    font-size: 1.5em;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    transition: all 0.3s ease;
}

.add-event-btn:hover,
.view-calendar-btn:hover {
    background: #0056b3;
    transform: scale(1.1);
}

.calendar {
    max-width: 900px;
    margin: 20px auto;
    border: 1px solid #ddd;
    border-radius: 10px;
    background: #fff;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    padding: 10px;
}

.calendar-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    background: #007bff;
    color: #fff;
    padding: 10px;
    font-size: 1.3em;
    font-weight: bold;
    border-radius: 5px 5px 0 0;
}

.nav-arrow {
    background: none;
    border: none;
    color: #fff;
    font-size: 1.5em;
    cursor: pointer;
}

.calendar-days {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    background: #007bff;
    color: white;
    text-align: center;
    padding: 8px;
    font-weight: bold;
}

.calendar-dates {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 5px;
    padding: 10px;
}

.day {
    border: 1px solid #ddd;
    border-radius: 5px;
    padding: 10px;
    text-align: center;
    background: #f9f9f9;
    min-height: 80px;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.day.today {
    background: #007bff;
    color: white;
    font-weight: bold;
}

.event {
    background: #e9ecef;
    color: #333;
    border-radius: 4px;
    padding: 4px;
    margin-top: 5px;
    font-size: 0.8em;
    text-align: left;
    overflow: hidden;
    white-space: nowrap;
    text-overflow: ellipsis;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.delete-event-btn {
    background: none;
    border: none;
    color: red;
    font-size: 0.8em;
    cursor: pointer;
    margin-left: 5px;
}

.delete-event-btn:hover {
    color: darkred;
}

/* Modal */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background: rgba(0, 0, 0, 0.5);
    justify-content: center;
    align-items: center;
}

.modal-content {
    background: white;
    padding: 15px 20px;
    border-radius: 10px;
    width: 90%;
    max-width: 400px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    position: relative;
}

.modal-content h3 {
    background: #007bff;
    color: white;
    margin: -15px -20px 15px;
    padding: 10px;
    text-align: center;
    border-radius: 10px 10px 0 0;
}

.modal-content .close {
    position: absolute;
    right: 15px;
    top: 10px;
    font-size: 1.2em;
    color: white;
    cursor: pointer;
}
</style>

<script>
    let currentMonth = <?= $currentMonth - 1 ?>; // Mes actual (0-indexado)
    let currentYear = <?= $currentYear ?>;

    const monthNames = [
        "Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio",
        "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"
    ];

    // Datos de eventos desde PHP
    const events = <?= json_encode($events, JSON_HEX_TAG); ?>; 

    function renderCalendar() {
        const calendarDates = document.getElementById("calendar-dates");
        const currentMonthYear = document.getElementById("current-month-year");

        // Actualizar encabezado con el mes y año actuales
        currentMonthYear.textContent = `${monthNames[currentMonth]} ${currentYear}`;
        calendarDates.innerHTML = ""; // Limpiar días del calendario

        const firstDay = new Date(currentYear, currentMonth, 1).getDay();
        const adjustedFirstDay = (firstDay === 0 ? 7 : firstDay); // Ajustar si el primer día es domingo

        const totalDays = new Date(currentYear, currentMonth + 1, 0).getDate();

        // Renderizar días vacíos antes del primer día del mes
        for (let i = 1; i < adjustedFirstDay; i++) {
            const emptyCell = document.createElement("div");
            emptyCell.classList.add("day", "empty");
            calendarDates.appendChild(emptyCell);
        }

        // Renderizar los días del mes
        for (let day = 1; day <= totalDays; day++) {
            const date = `${currentYear}-${String(currentMonth + 1).padStart(2, '0')}-${String(day).padStart(2, '0')}`;
            const dayCell = document.createElement("div");
            dayCell.classList.add("day");

            // Marcar el día de hoy
            const today = new Date().toISOString().slice(0, 10);
            if (date === today) {
                dayCell.classList.add("today");
            }

            // Mostrar el número del día
            dayCell.innerHTML = `<span>${day}</span>`;

            // Verificar y renderizar eventos correspondientes al día actual
            events.forEach(event => {
                // Depuración: Mostrar evento y día actual
                console.log(`Comparando evento (${event.fecha}) con fecha actual (${date})`);

                if (event.fecha === date) {
                    const eventDiv = document.createElement("div");
                    eventDiv.classList.add("event");
                    eventDiv.innerHTML = `
                        <span>${event.titulo} (${event.hora_inicio} - ${event.hora_fin})</span>
                        <button class="delete-event-btn" onclick="deleteEvent(${event.eventoID})">🗑️</button>
                    `;
                    dayCell.appendChild(eventDiv); // Agregar el evento al día
                }
            });

            calendarDates.appendChild(dayCell); // Agregar el día al calendario
        }
    }

    // Función para eliminar eventos
    function deleteEvent(eventId) {
        if (confirm("¿Estás seguro de que deseas eliminar este evento?")) {
            window.location.href = `index.php?r=site/delete-event&id=${eventId}`;
        }
    }

    // Cambiar mes
    function changeMonth(direction) {
        currentMonth += direction;

        // Ajustar el mes y el año si el mes sale de los límites
        if (currentMonth < 0) {
            currentMonth = 11;
            currentYear--;
        } else if (currentMonth > 11) {
            currentMonth = 0;
            currentYear++;
        }

        renderCalendar(); // Renderizar el nuevo mes
    }

    // Mostrar/Ocultar calendario
    function toggleCalendar() {
        const calendar = document.getElementById("calendar");
        calendar.style.display = calendar.style.display === "none" ? "block" : "none";
    }

    // Abrir el modal para agregar eventos
    function openModal() {
        document.getElementById("addEventModal").style.display = "flex";
    }

    // Cerrar el modal
    function closeModal() {
        document.getElementById("addEventModal").style.display = "none";
    }

    // Renderizar el calendario al cargar la página
    renderCalendar();
</script>

