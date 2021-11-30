<!-- filter checkbox -->
<!DOCTYPE html>
  <html>
    <head>
        <meta charset="utf-8" />
        <title>Final Project SIG</title>
        <meta name="viewport" content="initial-scale=1,maximum-scale=1,user-scalable=no" />
        <script src="https://api.mapbox.com/mapbox-gl-js/v2.0.1/mapbox-gl.js"></script>
        <link href="https://api.mapbox.com/mapbox-gl-js/v2.0.1/mapbox-gl.css" rel="stylesheet" />
        <link rel="stylesheet" href="../CSS/stylemap.css">

        <style>
            /* #mapid {
                width: 1360px;
                height: 720px;
                border: 1px solid #ccc;
            } */

            body { margin: 0; padding: 0; }
            #map { position: absolute; top: 0; bottom: 0; width: 100%; }
        </style>
        <style>
            .mapboxgl-popup {
                    max-width: 400px;
                    font: 12px/20px 'Helvetica Neue', Arial, Helvetica, sans-serif;
            }
    
            .filter-group {
                font: 12px/20px 'Helvetica Neue', Arial, Helvetica, sans-serif;
                font-weight: 600;
                position: absolute;
                top: 95px;
                left: 5px;
                z-index: 1;
                border-radius: 3px;
                width: 120px;
                color: #fff;
            }
    
            .filter-group input[type='checkbox']:first-child + label {
                border-radius: 3px 3px 0 0;
            }
    
            .filter-group label:last-child {
                border-radius: 0 0 3px 3px;
                border: none;
            }
    
            .filter-group input[type='checkbox'] {
                display: none;
            }
    
            .filter-group input[type='checkbox'] + label {
                background-color: #5fde4b;
                display: block;
                cursor: pointer;
                padding: 10px;
                border-bottom: 1px solid rgba(0, 0, 0, 0.25);
            }
    
            .filter-group input[type='checkbox'] + label {
                background-color: #3386c0;
                text-transform: capitalize;
            }
    
            .filter-group input[type='checkbox'] + label:hover,
            .filter-group input[type='checkbox']:checked + label {
                background-color: #5fde4b;
            }
    
            .filter-group input[type='checkbox']:checked + label:before {
                content: '✔';
                margin-right: 5px;
            }
        </style>
    </head>
    <body> 
        <div id="map"></div>
    {{-- <!-- <div id="mapid"></div> --> --}}

    <div id="mapid" class="ml-5"></div>
    <nav id="filter-group" class="filter-group"></nav>

    <script type="text/javascript">
        mapboxgl.accessToken = 'pk.eyJ1IjoiYW5nZ2FyYXlwIiwiYSI6ImNrajQyejZ3YTFudGcyenRkZWl6eGJ4dnoifQ.A1A07Wo4DfR_9OQaEmsXCQ';
        
        var layerIDs = []; // Will contain a list used to filter against.
        
        var filterGroup = document.getElementById('filter-group');

        var map = new mapboxgl.Map({
            container: 'map',
            style: 'mapbox://styles/mapbox/streets-v11',
            center: [112.79486538377762, -7.281475624500317],
            zoom: 15.5
        });

        var places = {
            'type': 'FeatureCollection',
            'features': [
                {   'type': 'Feature',
                    'properties': {
                        'description':
                            '<strong>Informatika</strong><p>Dalam perkuliahan di Informatika ITS, mahasiswa mendapatkan banyak ilmu dan pengalaman terkait komputer, pemrograman terstruktur, dan dalam tahap sarjana mahasiswa berhak memilih program studi yang disediakan.</p><p>https://www.instagram.com/hmtc_its/</p>',
                        'icon': 'FTEIC'
                    },
                    'geometry': {
                        'type': 'Point',
                        'coordinates': [112.79736595588975, -7.279610131414344]
                    }
                },
                {
                    'type': 'Feature',
                    'properties': {
                        'description':
                            '<strong>Sistem Informasi</strong><p>Departemen ini mempelajari pengembangan dan manajemen suatu sistem informasi, pemodelan proses bisnis, hingga integrasi sistem informasi.</p><p>https://www.instagram.com/hmsi_its/</p>',
                        'icon': 'FTEIC'
                    },
                    'geometry': {
                        'type': 'Point',
                        'coordinates': [112.79672180052921,-7.280428968958418]
                    }
                },
                {
                    'type': 'Feature',
                    'properties': {
                        'description':
                            '<strong>Teknik Biomedik</strong><p>Departemen Teknik Biomedik dibentuk dengan visi dan misi untuk mencetak generasi penerus yang memiliki kemampuan analisa dan sintesa yang kuat dalam bidang spesialisasi instrumentasi biomedik, pengolahan sinyal biomedik, biomekanika, kontrol biomedik, biomaterial, dan lain-lain.</p><p>https://www.instagram.com/hmtb_its/</p>',
                        'icon': 'FTEIC'
                    },
                    'geometry': {
                        'type': 'Point',
                        'coordinates': [112.7968915499116,-7.28467534227417]
                    }
                },
                {
                    'type': 'Feature',
                    'properties': {
                        'description':
                            '<strong>Teknik Komputer</strong><p>Departemen Teknik komputer adalah disiplin ilmu yang mewujudkan ilmu pengetahuan dan teknologi dari mendesain, membangun, mengimplementasikan, dan memelihara perangkat lunak (software) dan perangkat keras (hardware) dari sistem komputasi modern, peralatan yang dikontrol komputer, dan jaringan perangkat cerdas.</p><p>https://www.instagram.com/computer_its/</p>',
                        'icon': 'FTEIC'
                    },
                    'geometry': {
                        'type': 'Point',
                        'coordinates': [112.79723244060813,-7.285205860604904]
                    }
                },
                {
                    'type': 'Feature',
                    'properties': {
                        'description':
                            '<strong>Teknik Lingkungan</strong><p>Departemen ini mempelajari dan mengeksplorasi bidang rekayasa dan manajemen lingkungan, seperti misalnya Teknologi Penyediaan dan Pengolahan Air Minum, Penyaluran dan Pengolahan Air Limbah.</p><p>https://www.instagram.com/hmtl_its/</p>',
                            'icon': 'FTSPK'
                    },
                    'geometry': {
                        'type': 'Point',
                        'coordinates': [112.79259887863407, -7.279741207914341]
                    }
                },
                {
                    'type': 'Feature',
                    'properties': {
                        'description':
                            '<strong>Fisika</strong><p>Departemen ini mempelajari hukum dasar pengendali alam semesta dan penerapannya dalam teknologi untuk meningkatkan kesejahteraan umat manusia.</p><p>https://www.instagram.com/himasika_its/</p>',
                            'icon': 'FSAINS'
                    },
                    'geometry': {
                        'type': 'Point',
                        'coordinates': [112.79459807603337,-7.2844652988911065]
                    }
                },
                {
                    'type': 'Feature',
                    'properties': {
                        'description':
                            '<strong>Matematika</strong><p>Di Departemen Matematika ITS, kegiatan pendidikan dan penelitian diarahkan mulai dari matematika murni hingga aplikasinya ke berbagai bidang.</p><p>https://www.instagram.com/himatika_its/</p>',
                            'icon': 'FSAINS'
                    },
                    'geometry': {
                        'type': 'Point',
                        'coordinates': [112.79466322492954, -7.285294404518382]
                    }
                },
                {
                    'type': 'Feature',
                    'properties': {
                        'description':
                            '<strong>Statistika</strong><p>Departemen Statistika ITS bertujuan untuk mengembangkan statistika dan penerapannya di berbagai bidang, khususnya di bidang industri dan bisnis, komputasi, ekonomi finansial dan aktuaria, sosial dan kependudukan, serta lingkungan dan kesehatan.</p><p>https://www.instagram.com/himasta_its/</p>',
                            'icon': 'FSAINS'
                    },
                    'geometry': {
                        'type': 'Point',
                        'coordinates': [112.79411746470623, -7.285426418639233]
                    }
                },
                {
                    'type': 'Feature',
                    'properties': {
                        'description':
                            '<strong>Aktuaria</strong><p>Aktuaria adalah ilmu tentang pengelolaan risiko keuangan di masa yang akan datang. Ilmu aktuaria merupakan kombinasi antara ilmu tentang peluang, matematika, statistika, keuangan, dan pemrograman komputer.</p><p>https://www.instagram.com/aktuaria_its/</p>',
                            'icon': 'FSAINS'
                    },
                    'geometry': {
                        'type': 'Point',
                        'coordinates': [112.79389524915905,-7.2848446278047305]
                    }
                },
                {
                    'type': 'Feature',
                    'properties': {
                        'description':
                            '<strong>Kimia</strong><p>Di Departemen Kimia ITS, mahasiswa diajarkan untuk memahami konsep-konsep dasar ilmu kimia melalui perkuliahan dan pengalaman di laboratorium.</p><p>https://www.instagram.com/himka_its/</p>',
                            'icon': 'FSAINS'
                    },
                    'geometry': {
                        'type': 'Point',
                        'coordinates': [112.79472761172201, -7.2838797032318325]
                    }
                },
                {
                    'type': 'Feature',
                    'properties': {
                        'description':
                            '<strong>Biologi</strong><p>Di Departemen Biologi ITS, dosen dan mahasiswa diarahkan tidak hanya fokus meneliti aspek fundamental dari makhluk hidup, tetapi juga membahas pertanyaan kompleks yang berhubungan dengan aplikasi biosains dan bioteknologi.</p><p>https://www.instagram.com/officialhimabits/</p>',
                            'icon': 'FSAINS'
                    },
                    'geometry': {
                        'type': 'Point',
                        'coordinates': [112.793921069965, -7.285930642544173]
                    }
                },
                {
                    'type': 'Feature',
                    'properties': {
                        'description':
                            '<strong>Teknik Mesin</strong><p>Departemen ini mempelajari prinsip fisika yang kemudian diimplementasikan pada analisis, desain, manufaktur, dan pemeliharaan mesin.</p><p>https://www.instagram.com/hmm_its/</p>',
                            'icon': 'FTIRS'
                    },
                    'geometry': {
                        'type': 'Point',
                        'coordinates': [112.79609320413886, -7.284360804710829]
                    }
                },
                {
                    'type': 'Feature',
                    'properties': {
                        'description':
                            '<strong>Teknik Kimia</strong><p>Secara umum, teknik kimia merupakan ilmu untuk merancang dan mengoperasikan suatu pabrik, peralatan dan proses untuk mengubah bahan baku mentah menjadi bahan baku yang memiliki nilai ekonomi yang lebih tinggi.</p><p>https://www.instagram.com/himatekkits/</p>',
                            'icon': 'FTIRS'
                    },
                    'geometry': {
                        'type': 'Point',
                        'coordinates': [112.79670609331401, -7.282998154548963]
                    }
                },
                {
                    'type': 'Feature',
                    'properties': {
                        'description':
                            '<strong>Teknik Fisika</strong><p>Peserta didik di Departemen Teknik Fisika ITS dibekali dengan kemampuan riset dan pengembangan, perancangan dan analisa untuk berbagai sistem fisis di Industri.</p><p>https://www.instagram.com/hmtf_its/</p>',
                            'icon': 'FTIRS'
                    },
                    'geometry': {
                        'type': 'Point',
                        'coordinates': [112.79565116309982, -7.284434800926817]
                    }
                },
                {
                    'type': 'Feature',
                    'properties': {
                        'description':
                            '<strong>Teknik Industri</strong><p>Di departemen ini, mahasiswa ITS akan mempelajari cara merancang, mengelola, dan menerapkan semua elemen industri, seperti manusia, mesin, metode, material, dan lingkungan menjadi sistem yang berkaitan dengan fungsi pabrik.</p><p>https://www.instagram.com/hmti_its/</p>',
                            'icon': 'FTIRS'
                    },
                    'geometry': {
                        'type': 'Point',
                        'coordinates': [112.79749947775906, -7.283769437662343]
                    }
                },
                {
                    'type': 'Feature',
                    'properties': {
                        'description':
                            '<strong>Teknik Material dan Metalurgi</strong><p>Material dan metalurgi merupakan bidang ilmu paling multidisipliner dan dinamis di bidang teknik. Engineer di bidang material menggali ilmu dan pemahaman tentang hubungan fundamental antara struktur, proses dan performa material untuk membuat material sintesis dan mengembangkan material baru.</p><p>https://www.instagram.com/hmmt_its/</p>',
                            'icon': 'FTIRS'
                    },
                    'geometry': {
                        'type': 'Point',
                        'coordinates': [112.79782687735133, -7.285117432842341]
                    }
                },
                {
                    'type': 'Feature',
                    'properties': {
                        'description':
                            '<strong>Teknik Sipil</strong><p>Departemen ini mengusung visi untuk menjadi pusat rujukan bidang Teknik Sipil di Indonesia yang inovatif dan bereputasi internasional.</p><p>https://www.instagram.com/hmtsits/</p>',
                            'icon': 'FTSPK'
                    },
                    'geometry': {
                        'type': 'Point',
                        'coordinates': [112.79331958047896, -7.28077092849982]
                    }
                },
                {
                    'type': 'Feature',
                    'properties': {
                        'description':
                            '<strong>Arsitektur</strong><p>Departemen ini mencetak mahasiswa yang siap membangun infrastruktur terbaik untuk memajukan Indonesia.</p><p>https://www.instagram.com/himasthapati/</p>',
                            'icon': 'FTSPK'
                    },
                    'geometry': {
                        'type': 'Point',
                        'coordinates': [112.79406958719653, -7.281237473282744]
                    }
                },
                {
                    'type': 'Feature',
                    'properties': {
                        'description':
                            '<strong>Perencanaan Wilayah dan Kota</strong><p>Departemen ini mencetak mahasiswa yang mampu memperbaiki wilayah perkotaan Indonesia. Mahasiswa akan belajar mengenai faktor-faktor pembentuk lingkungan hidup yang ideal, mulai dari kependudukan, lingkungan, kondisi politik, hingga kondisi sosial penduduk.</p><p>https://www.instagram.com/urplanhmpl/</p>',
                            'icon': 'FTSPK'
                    },
                    'geometry': {
                        'type': 'Point',
                        'coordinates': [112.79437907128317, -7.279703443837533]
                    }
                },
                {
                    'type': 'Feature',
                    'properties': {
                        'description':
                            '<strong>Teknik Geomatika</strong><p>Departemen ini mengusung visi menjadi institusi bertaraf internasional dalam pemanfaatan, pengembangan ilmu dan teknologi survei pemetaan untuk menunjang industri informasi geospasial dan pengelolaan sumber daya alam.</p><p>https://www.instagram.com/himage_its/</p>',
                            'icon': 'FTSPK'
                    },
                    'geometry': {
                        'type': 'Point',
                        'coordinates': [112.79459914733957, -7.280137417948666]
                    }
                },
                {
                    'type': 'Feature',
                    'properties': {
                        'description':
                            '<strong>Teknik Geofisika</strong><p>Departemen ini merupakan disiplin ilmu rekayasa dan teknologi untuk meneliti struktur pelapisan bumi di bawah permukaan bumi dengan memanfaatkan sifat-sifat fisik batuan/material yang ada dibumi..</p><p>https://www.instagram.com/hmtg_its/</p>',
                            'icon': 'FTSPK'
                    },
                    'geometry': {
                        'type': 'Point',
                        'coordinates': [112.79539748552656, -7.279972478362822]
                    }
                },
                {
                    'type': 'Feature',
                    'properties': {
                        'description':
                            '<strong>Teknik Perkapalan</strong><p>Departemen ini merupakan pelopor pengembangan ilmu kemaritiman di Indonesia dan Asia Tenggara. Mahasiswa departemen ini akan mempelajari, meneliti, mendesain pembangunan kapal, pengembangan sistem transportasi hingga menjalankan operasi bisnis dalam armada laut.</p><p>https://www.instagram.com/himatekpal/</p>',
                            'icon': 'FTK'
                    },
                    'geometry': {
                        'type': 'Point',
                        'coordinates': [112.7972081939647, -7.282113478336001]
                    }
                },
                {
                    'type': 'Feature',
                    'properties': {
                        'description':
                            '<strong>Teknik Sistem Perkapalan</strong><p>Departemen ini bertujuan mencetak profesional dan akademisi muda yang mempunyai kemampuan dalam perancangan instalasi, manajerial, serta perawatan dan perbaikan untuk berbagai instalasi kapal dan bangunan lepas pantai. Departemen ini juga menyediakan program Double Degree yang bekerja sama dengan Wismar University, Jerman.</p><p>https://www.instagram.com/himasiskalits/</p>',
                            'icon': 'FTK'
                    },
                    'geometry': {
                        'type': 'Point',
                        'coordinates': [112.79674046215462, -7.282124662487405]
                    }
                },
                {
                    'type': 'Feature',
                    'properties': {
                        'description':
                            '<strong>Teknik Kelautan</strong><p>Departemen ini merupakan program studi tertua di Indonesia dalam bidang teknik kelautan. Departemen yang berdiri sejak 1983 ini mempunyai tujuan melahirkan lulusan yang ahli di bidang desain, konstruksi, pemeliharaan struktur pantai dan lepas pantai, serta bidang konservasi energi dan lingkungan laut.</p><p>https://www.instagram.com/himatekla.its/</p>',
                            'icon': 'FTK'
                    },
                    'geometry': {
                        'type': 'Point',
                        'coordinates': [112.79697342465249, -7.281750653089134]
                    }
                },
                {
                    'type': 'Feature',
                    'properties': {
                        'description':
                            '<strong>Teknik Transportasi Laut</strong><p>Teknologi pengembangan kemaritiman di ITS telah difokuskan pada pengembangan hardware seperti kapal, pembangunan bangunan lepas laut dan sistem kapal. Untuk itu, ITS membutuhkan bidang studi yang secara spesifik mempelajari managerial dan aspek operasional dari kapal (operasional maritim).</p><p>https://www.instagram.com/himaseatrans_its/</p>',
                            'icon': 'FTK'
                    },
                    'geometry': {
                        'type': 'Point',
                        'coordinates': [112.79799945660466, -7.282119101811915]
                    }
                },
                {
                    'type': 'Feature',
                    'properties': {
                        'description':
                            '<strong>Teknik Elektro</strong><p>Departemen ini merupakan bidang ilmu profesional yang mempelajari aplikasi kelistrikan, elektronika, dan elektromagnet. Di Departemen Teknik Elektro ITS, dosen dan mahasiswa ditantang untuk terus berinovasi dan mengembangkan teknologi baru untuk mengatasi berbagai persoalan yang berhubungan dengan kedokteran, energi, dan lingkungan.</p> <p>https://www.instagram.com/himatektro_its/</p>',
                            'icon': 'FTEIC'
                    },
                    'geometry': {
                        'type': 'Point',
                        'coordinates': [112.79607256889426, -7.284931712522052]
                    }
                },
                {
                    'type': 'Feature',
                    'properties': {
                        'description':
                            '<strong>Teknologi Informasi</strong><p>Departemen ini menghasilkan mahasiswa yang berkompeten dalam hal Informatika, siap bersaing dan berkompetisi, serta dapat berkontribusi untuk kesejahteraan masyarakat. Mahasiswa Departemen Teknologi Informasi akan mempelajari seputar bahasa pemrograman, algoritma pemrograman, jaringan komputer, pengolahan citra digital, dan masih banyak lagi.</p> <p>https://www.instagram.com/hmit_its/</p>',
                            'icon': 'FTEIC'
                    },
                    'geometry': {
                        'type': 'Point',
                        'coordinates': [112.79552613162559, -7.28180101367785]
                    }
                },
                {
                    'type': 'Feature',
                    'properties': {
                        'description':
                            '<strong>Desain Produk</strong><p>Dalam Departemen Desain Produk mahasiswa akan belajar untuk menciptakan gagasan inovatif dalam menyelesaikan permasalahan terkait produk yang bermanfaat bagi masyarakat. Selain itu, di era globalisasi dan ekonomi kreatif, inovasi dan kreatifitas merupakan salah satu faktor yang dapat meningkatkan keunggulan suatu bangsa.</p><p>https://www.instagram.com/himaideits/</p>',
                            'icon': 'CREABIZ'
                    },
                    'geometry': {
                        'type': 'Point',
                        'coordinates': [112.7964971015482, -7.278793244238344]
                    }
                },
                {
                    'type': 'Feature',
                    'properties': {
                        'description':
                            '<strong>Desain Interior</strong><p>Departemen ini merupakan bidang ilmu desain yang mempelajari perencanaan tata letak dan mengimplementasikan konsep desain pada ruang dalam sehingga mewujudkan interior yang estetik, nyaman dan aman untuk penghuninya. Departemen ini berfokus kepada pendalaman dan penguasaan bidang keahlian desain interior dengan obyek desain yang nyata sehingga melahirkan lulusan yang mumpuni dan berkompetensi tinggi pada bidang desain interior.</p><p>https://www.instagram.com/interiordesignits/</p>',
                            'icon': 'CREABIZ'
                    },
                    'geometry': {
                        'type': 'Point',
                        'coordinates': [112.79584473433806, -7.278993274621072]
                    }
                },
                {
                    'type': 'Feature',
                    'properties': {
                        'description':
                            '<strong>Desain Komunikasi Visual</strong><p>Dalam Desain Komunikasi Visual, mahasiswa akan belajar menciptakan komunikasi yang dibentuk dalam bahasa visual sehingga pesan yang ingin di sampaikan dapat diterima dengan metode yang kreatif. Lulusan Desain Komunikasi Visual berpeluang bekerja di bidang: Periklanan, Branding, Desain Grafis, Penerbitan, Percetakan, Pengembang Animasi dan Game, Film dan Televisi, dengan profesi sebagai Desainer, Konseptor, Ilustrator atau Animator.</p><p>https://www.instagram.com/visualdesignits/</p>',
                            'icon': 'CREABIZ'
                    },
                    'geometry': {
                        'type': 'Point',
                        'coordinates': [112.79663247284111, -7.279081566706793]
                    }
                },
                {
                    'type': 'Feature',
                    'properties': {
                        'description':
                            '<strong>Manajemen Bisnis</strong><p>Departemen ini mempersiapkan lulusan yang mampu berkarir didunia bisnis sebagai profesional menejerial maupun pebisnis dengan semangat inovasi dan entrepreneurship. Mahasiswa Manajemen bisnis akan diberikan wawasan mengenai perancang strategis bisnis berbasis teknologi guna mengelola inovasi yang tepat bagi pengembangan masyarakat Indonesia.</p><p>https://www.instagram.com/bmsa_its/</p>',
                            'icon': 'CREABIZ'
                    },
                    'geometry': {
                        'type': 'Point',
                        'coordinates': [112.79262370666072, -7.277792688063997]
                    }
                }
            ]
        };

        map.on('load', function () {
            map.loadImage(
                'https://docs.mapbox.com/mapbox-gl-js/assets/custom_marker.png',
                // Add an image to use as a custom marker
                function (error, image) {
                    if (error) throw error;
                    map.addImage('custom-marker', image);

                    map.addSource('places', {
                        'type': 'geojson',
                        'data': places
                    });

                    places.features.forEach(function (feature) {
                        var symbol = feature.properties['icon'];
                        var layerID = 'poi-' + symbol;
                        console.log

                        // Add a layer for this symbol type if it hasn't been added already.
                        if (!map.getLayer(layerID)) {
                            map.addLayer({
                                'id': layerID,
                                'type': 'symbol',
                                'source': 'places',
                                'layout': {
                                    'icon-image': 'custom-marker',
                                    'icon-allow-overlap': true,
                                },
                                'filter': ['==', 'icon', symbol]
                            });

                            // Add checkbox and label elements for the layer.
                            var input = document.createElement('input');
                            input.type = 'checkbox';
                            input.id = layerID;
                            input.checked = true;
                            filterGroup.appendChild(input);

                            var label = document.createElement('label');
                            label.setAttribute('for', layerID);
                            label.textContent = symbol;
                            filterGroup.appendChild(label);

                            // When the checkbox changes, update the visibility of the layer.
                            input.addEventListener('change', function (e) {
                                map.setLayoutProperty(
                                    layerID,
                                    'visibility',
                                    e.target.checked ? 'visible' : 'none'
                                );
                            });

                            // Create a popup, but don't add it to the map yet.
                            var popup = new mapboxgl.Popup({
                                closeButton: false,
                                closeOnClick: false
                            });

                            map.on('mouseenter', layerID, function (e) {
                                // Change the cursor style as a UI indicator.
                                map.getCanvas().style.cursor = 'pointer';

                                var coordinates = e.features[0].geometry.coordinates.slice();
                                var description = e.features[0].properties.description;

                                // Ensure that if the map is zoomed out such that multiple
                                // copies of the feature are visible, the popup appears
                                // over the copy being pointed to.
                                while (Math.abs(e.lngLat.lng - coordinates[0]) > 180) {
                                    coordinates[0] += e.lngLat.lng > coordinates[0] ? 360 : -360;
                                }

                                // Populate the popup and set its coordinates
                                // based on the feature found.
                                popup.setLngLat(coordinates).setHTML(description).addTo(map);
                            });

                            map.on('mouseleave', layerID, function () {
                                map.getCanvas().style.cursor = '';
                                popup.remove();
                            });

                            layerIDs.push(layerID);
                        }
                    });
                }
            );
        });

        // map.addControl(
        //         new mapboxgl.NavigationControl(),
        //         'bottom-left'
        // );

    </script>
    </body>
  </html>