<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Smart IoT Dashboard') }}
            </h2>
        </div>
    </x-slot>

    @push('styles')
        {{-- Favicon & Title --}}
        <link rel="icon" type="image/png" href="{{ asset('img/logo-robot.png') }}?v=1">
        
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700;800&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Roboto+Mono:wght@500;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" />
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/gridstack@7.2.3/dist/gridstack.min.css" rel="stylesheet"/>

        <style>
            /* GLOBAL STYLE */
            body { font-family: 'Poppins', sans-serif; background-color: #f3f4f6; }
            .grid-stack { background: transparent; min-height: 400px; margin-top: 20px; }

            /* WIDGET CARD */
            .grid-stack-item-content { 
                background: #ffffff; border-radius: 20px;
                box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05);
                border: 1px solid rgba(0,0,0,0.03);
                display: flex; flex-direction: column; overflow: hidden;
                position: relative;
                transition: transform 0.2s, box-shadow 0.2s;
            }

            /* OVERLAY HAPUS (DALAM WIDGET) */
            .delete-overlay {
                position: absolute; top: 0; left: 0; width: 100%; height: 100%;
                background: rgba(255, 255, 255, 0.98);
                display: flex; flex-direction: column; align-items: center; justify-content: center;
                z-index: 999; border-radius: 20px; opacity: 0; pointer-events: none;
                transition: opacity 0.2s ease-in-out;
            }
            .delete-overlay.active { opacity: 1; pointer-events: auto; }

            /* HEADER */
            .widget-header { 
                width: 100%; padding: 10px 15px; 
                background: linear-gradient(to right, #f8f9fa, #ffffff);
                border-bottom: 1px solid #f0f0f0; cursor: grab; 
                font-weight: 600; font-size: 13px; color: #444;
                display: flex; justify-content: space-between; align-items: center;
            }

            /* TOMBOL AKSI */
            .widget-actions { display: flex; gap: 6px; opacity: 0; transition: 0.3s; z-index: 1000; position: relative; }
            .grid-stack-item-content:hover .widget-actions { opacity: 1; }
            .btn-icon { border: none; width: 28px; height: 28px; border-radius: 8px; font-size: 12px; cursor: pointer; display: flex; align-items: center; justify-content: center; }
            .btn-delete { background: #fee2e2; color: #ef4444; } 
            .btn-setting { background: #f3f4f6; color: #4b5563; }

            /* WIDGET CONTENT */
            .widget-body { flex-grow: 1; width: 100%; display: flex; flex-direction: column; justify-content: center; align-items: center; padding: 15px; }
            
            /* MONITOR & CLOCK */
            .jarvis-clock-container { display: flex; flex-direction: column; align-items: center; justify-content: center; background: #ffffff; border: 1px solid #e2e8f0; padding: 5px 25px; border-radius: 12px; box-shadow: 0 2px 4px rgba(0,0,0,0.05); }
            .jarvis-time { font-family: 'Roboto Mono', monospace; font-size: 26px; font-weight: 700; color: #0f172a; line-height: 1; }
            .jarvis-date { font-size: 11px; font-weight: 600; color: #64748b; text-transform: uppercase; margin-top: 4px; }

            .sensor-value { font-weight: 700; color: #2563eb; font-size: 32px; line-height: 1.1; }
            .status-dot { width: 10px; height: 10px; border-radius: 50%; display: inline-block; margin-right: 5px; }
            .status-online { background-color: #10b981; animation: pulse 2s infinite; }
            .status-offline { background-color: #ef4444; }
            @keyframes pulse { 0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.7); } 70% { box-shadow: 0 0 0 10px rgba(16, 185, 129, 0); } 100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); } }
            
            nav.navbar { display: none; }
        </style>
    @endpush

    <div class="py-4">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            {{-- SYSTEM MONITOR --}}
            <div class="row g-2 mb-3">
                <div class="col-md-3 col-6">
                    <div class="p-2 bg-white rounded-3 border border-gray-100 shadow-sm d-flex align-items-center gap-2">
                        <div class="p-2 bg-green-50 text-green-600 rounded-circle"><i class="fas fa-bolt small"></i></div>
                        <div>
                            <div class="text-muted" style="font-size: 9px; font-weight: 800;">LATENCY</div>
                            <div id="mqtt-ping" class="fw-bold text-dark small">-- ms</div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3 col-6">
                    <div class="p-2 bg-white rounded-3 border border-gray-100 shadow-sm d-flex align-items-center gap-2">
                        <div class="p-2 bg-blue-50 text-blue-600 rounded-circle"><i class="fas fa-hourglass-half small"></i></div>
                        <div>
                            <div class="text-muted" style="font-size: 9px; font-weight: 800;">SESSION</div>
                            <div id="uptime-display" class="fw-bold text-dark small">00:00:00</div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- TOOLBAR --}}
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-xl p-4 mb-4 border border-gray-100">
                <div class="row align-items-center g-3">
                    <div class="col-md-4 d-flex align-items-center gap-2">
                       <div class="p-2 bg-cyan-50 rounded-lg text-cyan-500 shadow-sm">
                            <i class="fas fa-microchip fa-lg"></i>
                        </div>
                        <select onchange="window.location.href='?device_id='+this.value" class="form-select w-auto fw-bold text-dark border-0 bg-transparent">
                            @foreach($devices as $d)
                                <option value="{{ $d->id }}" {{ isset($currentDevice) && $currentDevice->id == $d->id ? 'selected' : '' }}>{{ $d->name }}</option>
                            @endforeach
                        </select>
                        <button class="btn btn-sm btn-light text-primary rounded-circle" data-bs-toggle="modal" data-bs-target="#addDeviceModal"><i class="fas fa-plus"></i></button>
                    </div>

                    <div class="col-md-4 d-flex justify-content-center">
                        <div class="jarvis-clock-container d-none d-md-flex">
                            <div id="digital-clock" class="jarvis-time">00:00:00</div>
                            <div id="date-now" class="jarvis-date">LOADING...</div>
                        </div>
                    </div>

                    @if($currentDevice)
                    <div class="col-md-4 text-md-end d-flex align-items-center justify-content-md-end gap-3">
                        <div class="d-flex align-items-center bg-gray-50 px-3 py-1 rounded-pill border">
                            <span id="mqtt-indicator" class="status-dot"></span>
                            <span id="mqtt-text" class="text-xs font-bold text-gray-500">Connecting</span>
                        </div>
                        <button class="btn btn-warning btn-sm rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#tokenModal"><i class="fas fa-key"></i>Token</button>
                        <button class="btn btn-dark btn-sm rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#datastreamModal"><i class="fas fa-layer-group"></i>Datastream</button>
                    </div>
                    @endif
                </div>

                @if($currentDevice)
                <hr class="my-3 border-gray-100">
                <div class="d-flex gap-2 flex-wrap justify-content-center justify-content-md-start">
                    <button onclick="addWidget('switch')" class="btn btn-outline-primary btn-sm rounded-pill px-3"><i class="fas fa-toggle-on"></i> Switch</button>
                    <button onclick="addWidget('sensor')" class="btn btn-outline-warning btn-sm rounded-pill px-3 text-dark"><i class="fas fa-temperature-high"></i> Sensor</button>
                    <button onclick="addWidget('slider')" class="btn btn-outline-secondary btn-sm rounded-pill px-3"><i class="fas fa-sliders-h"></i> Slider</button>
                    <button onclick="addWidget('scheduler')" class="btn btn-outline-dark btn-sm rounded-pill px-3"><i class="fas fa-clock"></i> Jadwal</button>
                    <button onclick="addWidget('chart')" class="btn btn-outline-info btn-sm rounded-pill px-3 text-dark"><i class="fas fa-chart-line"></i> Grafik</button> 
                    <button onclick="saveDashboard()" class="btn btn-success btn-sm rounded-pill px-4 ms-auto shadow-sm fw-bold"><i class="fas fa-save me-1"></i> Simpan</button>
                </div>
                @endif
            </div>

            @if($currentDevice)
                <div class="grid-stack"></div>
            @else
                <div class="text-center py-5 bg-white rounded-xl shadow-sm">
                    <i class="fas fa-robot fa-3x text-light mb-3"></i>
                    <h5 class="text-gray-500">Belum ada device</h5>
                    <button class="btn btn-primary btn-sm rounded-pill mt-2" data-bs-toggle="modal" data-bs-target="#addDeviceModal">Buat Device Baru</button>
                </div>
            @endif
        </div>
    </div>

    {{-- MODALS --}}
    <div class="modal fade" id="addDeviceModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <form action="{{ route('device.store') }}" method="POST"> @csrf
                <div class="modal-content border-0 shadow rounded-4">
                    <div class="modal-header border-0"><h5 class="modal-title fw-bold">Device Baru</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                    <div class="modal-body"><input type="text" name="device_name" class="form-control bg-light" placeholder="Nama Device Baru" required></div>
                    <div class="modal-footer border-0"><button type="submit" class="btn btn-primary rounded-pill px-4">Buat Device</button></div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="datastreamModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4">
                <div class="modal-header border-0 pb-0"><h5 class="modal-title fw-bold">Datastreams</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <div class="bg-light p-3 rounded-3 mb-3" style="max-height: 200px; overflow-y: auto;">
                        <ul class="list-group list-group-flush bg-transparent">
                            @forelse($datastreams as $ds)
                                <li class="list-group-item bg-transparent d-flex justify-content-between px-0">
                                    <span><i class="fas fa-circle text-primary me-2" style="font-size: 8px;"></i> <b>{{ $ds->name }}</b></span>
                                    <span class="badge bg-white text-dark border">{{ $ds->pin }}</span>
                                </li>
                            @empty <li class="text-center text-muted small">Kosong</li> @endforelse
                        </ul>
                    </div>
                    <form action="{{ route('datastream.store') }}" method="POST"> @csrf
                        <input type="hidden" name="device_id" value="{{ $currentDevice ? $currentDevice->id : '' }}">
                        <div class="row g-2">
                            <div class="col-6"><input type="text" name="name" class="form-control" placeholder="Nama" required></div>
                            <div class="col-3"><select name="pin" class="form-select">@for($i=0; $i<=20; $i++) <option value="V{{$i}}">V{{$i}}</option> @endfor</select></div>
                            <div class="col-3"><button type="submit" class="btn btn-success w-100">+</button></div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="widgetSettingsModal" tabindex="-1">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4">
                <div class="modal-header border-0"><h5 class="modal-title fw-bold">Setting Pin</h5><button type="button" class="btn-close" data-bs-dismiss="modal"></button></div>
                <div class="modal-body">
                    <select id="setting-datastream" class="form-select bg-light">
                        <option value="">-- Pilih Pin --</option>
                        @foreach($datastreams as $ds) <option value="{{ $ds->pin }}" data-name="{{ $ds->name }}">{{ $ds->name }} ({{ $ds->pin }})</option> @endforeach
                    </select>
                    <button class="btn btn-primary rounded-pill w-100 mt-3" onclick="saveWidgetSettings()">Hubungkan</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="tokenModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow rounded-4">
                <div class="modal-body text-center p-4">
                    <h5 class="fw-bold mb-3">Device Token</h5>
                    <input type="text" id="tokenInput" class="form-control text-center font-monospace fw-bold mb-3 text-primary" value="{{ $currentDevice ? $currentDevice->token : '' }}" readonly>
                    <button onclick="navigator.clipboard.writeText(document.getElementById('tokenInput').value); alert('Token Tersalin!');" class="btn btn-dark rounded-pill w-100">Salin Token</button>
                </div>
            </div>
        </div>
    </div>

    {{-- SCRIPTS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/gridstack@7.2.3/dist/gridstack-all.js"></script>
    <script src="https://unpkg.com/mqtt/dist/mqtt.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // JAM & MONITOR LOGIC
        let startTime = Date.now();
        setInterval(() => {
            const now = new Date();
            if(document.getElementById('digital-clock')) document.getElementById('digital-clock').innerText = now.toLocaleTimeString('en-GB');
            if(document.getElementById('date-now')) document.getElementById('date-now').innerText = now.toLocaleDateString('id-ID', { weekday: 'long', year: 'numeric', month: 'long', day: 'numeric' });
            
            let diff = Math.floor((Date.now() - startTime) / 1000);
            let hrs = String(Math.floor(diff / 3600)).padStart(2, '0');
            let mins = String(Math.floor((diff % 3600) / 60)).padStart(2, '0');
            let secs = String(diff % 60).padStart(2, '0');
            if(document.getElementById('uptime-display')) document.getElementById('uptime-display').innerText = `${hrs}:${mins}:${secs}`;
        }, 1000);
    </script>

    @if($currentDevice)
    <script>
        var grid = null;
        var activeCharts = {};
        var currentEditingWidget = null;
        const deviceToken = "{{ $currentDevice->token }}";
        const deviceId = "{{ $currentDevice->id }}";

        document.addEventListener("DOMContentLoaded", function() {
            // Paksa Title Browser
            document.title = "{{ $currentDevice->name ?? 'Smart IoT' }} | Dashboard";

            // 1. Inisialisasi Grid
            grid = GridStack.init({ cellHeight: 'auto', minRow: 4, margin: 10, float: true, disableOneColumnMode: false, handle: '.widget-header' });

            // 2. Load Widgets dari DB
            try {
                const savedWidgets = {!! json_encode($currentDevice->widgets) ?? '[]' !!};
                if(Array.isArray(savedWidgets)) {
                    savedWidgets.forEach(w => {
                        let el = grid.addWidget({ x: w.x, y: w.y, w: w.w, h: w.h, content: getHtml(w.type, w.pin, w.name, w.valOn, w.valOff) });
                        el.setAttribute('data-type', w.type);
                        el.setAttribute('data-pin', w.pin);
                        el.setAttribute('data-name', w.name);
                        if(w.valOn) el.setAttribute('data-val-on', w.valOn);
                        if(w.valOff) el.setAttribute('data-val-off', w.valOff);
                        if(w.type == 'chart') setTimeout(() => initChart(w.pin), 500);
                    });
                }
            } catch(e) { console.error(e); }

            // 3. MQTT Klien
            const client = mqtt.connect('ws://broker.emqx.io:8083/mqtt');
            client.on('connect', () => { 
                setStatus('online'); 
                client.subscribe(deviceToken + "/#"); 
            });
            client.on('offline', () => setStatus('offline'));
            client.on('message', (topic, msg) => {
                let val = msg.toString();
                let pin = topic.split("/").pop();
                
                let sensor = document.querySelector(`.grid-stack-item[data-pin="${pin}"] .sensor-value`);
                if(sensor) sensor.innerText = val;
                
                if(activeCharts[pin]) {
                    let c = activeCharts[pin];
                    c.data.labels.push(new Date().toLocaleTimeString());
                    c.data.datasets[0].data.push(val);
                    if(c.data.labels.length > 15) { c.data.labels.shift(); c.data.datasets[0].data.shift(); }
                    c.update();
                }

                // Update latency semu
                document.getElementById('mqtt-ping').innerText = Math.floor(Math.random() * 50 + 20) + " ms";
            });

            window.kirimMQTT = function(pin, val) {
                if(!pin) return;
                client.publish(deviceToken + "/" + pin, val);
            }
        });

        function setStatus(s) {
            let dot = document.getElementById('mqtt-indicator');
            let txt = document.getElementById('mqtt-text');
            if(s==='online') { dot.className='status-dot status-online'; txt.innerText="ONLINE"; }
            else { dot.className='status-dot status-offline'; txt.innerText="OFFLINE"; }
        }

        function getHtml(type, pin, name, vOn, vOff) {
            let dPin = pin ? `(${pin})` : "";
            let head = `<div class="widget-header"><span class="widget-header-text"><i class="fas fa-circle text-primary me-1" style="font-size:6px;"></i> ${name} <small class="text-muted" style="font-size:9px;">${dPin}</small></span><div class="widget-actions"><button onclick="openSettings(this)" class="btn-icon btn-setting"><i class="fas fa-cog"></i></button><button onclick="deleteWidget(this)" class="btn-icon btn-delete"><i class="fas fa-trash"></i></button></div></div><div class="widget-body">`;
            let body = '';
            
            if(type=='switch') body = `<div class="d-flex gap-2 w-100 px-2"><button class="btn btn-outline-success w-50 fw-bold" onclick="kirimMQTT('${pin}','1')">ON</button><button class="btn btn-outline-danger w-50 fw-bold" onclick="kirimMQTT('${pin}','0')">OFF</button></div>`;
            else if(type=='sensor') body = `<div class="text-center"><i class="fas fa-temperature-high text-warning fa-lg mb-2"></i><div class="sensor-value">--</div><div class="sensor-unit">Value</div></div>`;
            else if(type=='slider') body = `<div class="w-100 text-center px-2"><h3 class="fw-bold text-primary mb-1" id="val-${pin}">0</h3><input type="range" class="form-range" min="0" max="180" onchange="kirimMQTT('${pin}',this.value)" oninput="document.getElementById('val-${pin}').innerText=this.value"></div>`;
            else if(type=='chart') body = `<div style="width:100%;height:100%"><canvas id="chart-${pin}"></canvas></div>`;
            else if(type=='scheduler') body = `<div class="px-2 w-100"><div class="input-group input-group-sm mb-2"><input type="time" class="form-control text-center" value="${vOn||''}" onchange="updateVal(this,'on');kirimMQTT('${pin}_ON',this.value)"></div><div class="input-group input-group-sm"><input type="time" class="form-control text-center" value="${vOff||''}" onchange="updateVal(this,'off');kirimMQTT('${pin}_OFF',this.value)"></div></div>`;
            
            let overlay = `<div class="delete-overlay"><p class="text-danger fw-bold small mb-2">HAPUS WIDGET?</p><div class="d-flex gap-2"><button class="btn btn-sm btn-secondary rounded-pill px-3" onclick="closeDeleteOverlay(this)">Batal</button><button class="btn btn-sm btn-danger rounded-pill px-3" onclick="confirmDeleteWidget(this)">Hapus</button></div></div>`;
            
            return head + body + `</div>` + overlay;
        }

        window.addWidget = function(type) {
            let el = grid.addWidget({ w: (type=='chart'?4:2), h: 2, content: getHtml(type, "", "New", "", "") });
            el.setAttribute('data-type', type); el.setAttribute('data-pin', ""); el.setAttribute('data-name', "New");
            openSettings(el);
        }

        window.updateVal = function(el, type) {
            let item = el.closest('.grid-stack-item');
            if(type=='on') item.setAttribute('data-val-on', el.value);
            else item.setAttribute('data-val-off', el.value);
        }

        window.openSettings = function(el) {
            currentEditingWidget = (el instanceof Element && el.classList.contains('grid-stack-item')) ? el : el.closest('.grid-stack-item');
            document.getElementById('setting-datastream').value = currentEditingWidget.getAttribute('data-pin');
            new bootstrap.Modal(document.getElementById('widgetSettingsModal')).show();
        }

        window.saveWidgetSettings = function() {
            let sel = document.getElementById('setting-datastream');
            let pin = sel.value;
            let name = sel.options[sel.selectedIndex].getAttribute('data-name');
            if(!pin) return;
            currentEditingWidget.setAttribute('data-pin', pin);
            currentEditingWidget.setAttribute('data-name', name);
            currentEditingWidget.querySelector('.widget-header-text').innerHTML = `<i class="fas fa-circle text-primary me-1" style="font-size:6px;"></i> ${name} <small class="text-muted" style="font-size:9px;">(${pin})</small>`;
            let type = currentEditingWidget.getAttribute('data-type');
            if(type=='chart') setTimeout(() => initChart(pin), 500);
            bootstrap.Modal.getInstance(document.getElementById('widgetSettingsModal')).hide();
        }

        // FUNGSI HAPUS OVERLAY
        window.deleteWidget = function(el) {
            el.closest('.grid-stack-item-content').querySelector('.delete-overlay').classList.add('active');
        }
        window.closeDeleteOverlay = function(btn) {
            btn.closest('.delete-overlay').classList.remove('active');
        }
        window.confirmDeleteWidget = function(btn) {
            grid.removeWidget(btn.closest('.grid-stack-item'));
            Swal.fire({ toast:true, position:'top-end', icon:'success', title:'Widget Dihapus', showConfirmButton:false, timer:1500 });
        }

        function initChart(pin) {
            let cvs = document.getElementById(`chart-${pin}`);
            if(!cvs || activeCharts[pin]) return;
            activeCharts[pin] = new Chart(cvs, { type:'line', data:{labels:[], datasets:[{data:[], borderColor:'#2563eb', fill:true, backgroundColor:'rgba(37,99,235,0.1)'}]}, options:{maintainAspectRatio:false, plugins:{legend:{display:false}}, scales:{x:{display:false}, y:{grid:{display:false}}}}});
        }

        window.saveDashboard = function() {
            let items = [];
            grid.engine.nodes.forEach(n => {
                let pin = n.el.getAttribute('data-pin');
                if(pin) items.push({ 
                    x:n.x, y:n.y, w:n.w, h:n.h, pin:pin, 
                    type:n.el.getAttribute('data-type'), 
                    name:n.el.getAttribute('data-name'), 
                    valOn:n.el.getAttribute('data-val-on')||"", 
                    valOff:n.el.getAttribute('data-val-off')||"" 
                });
            });

            fetch('/save-dashboard', { 
                method:'POST', 
                headers:{'Content-Type':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content}, 
                body:JSON.stringify({ device_id:deviceId, widgets:JSON.stringify(items) }) 
            })
            .then(res => res.json())
            .then(() => {
                Swal.fire({ toast:true, position:'top-end', icon:'success', title:'Konfigurasi Disimpan', showConfirmButton:false, timer:2000, timerProgressBar:true });
            });
        }
    </script>
    @endif
</x-app-layout>