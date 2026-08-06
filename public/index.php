<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wordle Solver Dashboard</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

    <div class="container">

        <!-- ================= HEADER ================= -->

        <header class="header">

            <div class="logo">
                🎯 <span>Wordle Solver</span>
            </div>

            <div class="header-right">

                <button id="themeBtn">
                    🌙 Dark
                </button>

                <div class="api-status">
                    API :
                    <span class="status online"></span>
                    Connected
                </div>

            </div>

        </header>

        <!-- ================= MAIN ================= -->

        <main class="main">

            <!-- ================= BOARD ================= -->

            <section class="board-section">

                <div class="board">

                    <!-- Row 1 -->

                    <div class="row">
                        <div class="tile"></div>
                        <div class="tile"></div>
                        <div class="tile"></div>
                        <div class="tile"></div>
                        <div class="tile"></div>
                    </div>

                    <!-- Row 2 -->

                    <div class="row">

                        <div class="tile green">S</div>
                        <div class="tile yellow">L</div>
                        <div class="tile gray">A</div>
                        <div class="tile green">T</div>
                        <div class="tile gray">E</div>

                    </div>

                    <!-- Row 3 -->

                    <div class="row">
                        <div class="tile"></div>
                        <div class="tile"></div>
                        <div class="tile"></div>
                        <div class="tile"></div>
                        <div class="tile"></div>
                    </div>

                    <!-- Row 4 -->

                    <div class="row">
                        <div class="tile"></div>
                        <div class="tile"></div>
                        <div class="tile"></div>
                        <div class="tile"></div>
                        <div class="tile"></div>
                    </div>

                    <!-- Row 5 -->

                    <div class="row">
                        <div class="tile"></div>
                        <div class="tile"></div>
                        <div class="tile"></div>
                        <div class="tile"></div>
                        <div class="tile"></div>
                    </div>

                    <!-- Row 6 -->

                    <div class="row">
                        <div class="tile"></div>
                        <div class="tile"></div>
                        <div class="tile"></div>
                        <div class="tile"></div>
                        <div class="tile"></div>
                    </div>

                </div>

            </section>

            <!-- ================= SOLVER PANEL ================= -->

            <aside class="solver-panel">

                <h2>Solver Panel</h2>

                <hr>

                <div class="info">

                    <p>
                        <strong>Trạng thái:</strong>
                        Đang giải...
                    </p>

                    <p>
                        <strong>Lượt:</strong>
                        2 / 6
                    </p>

                    <p>
                        <strong>Candidates:</strong>
                        42
                    </p>

                    <p>
                        <strong>Chiến lược:</strong>
                        Entropy
                    </p>

                </div>

                <div class="actions">

                    <button class="primary">
                        ▶ Giải tự động
                    </button>

                    <button>
                        ⏭ Từng bước
                    </button>

                    <button>
                        ↻ Chơi lại
                    </button>

                </div>

                <hr>

                <h3>Lịch sử reasoning</h3>

                <div class="reasoning-log">

                    <div class="log-item">

                        #1

                        <strong>CRANE</strong>

                        →

                        1 Green

                        2 Yellow

                    </div>

                    <div class="log-item">

                        #2

                        <strong>SLATE</strong>

                        →

                        Filtered to

                        <strong>42 words</strong>

                    </div>

                    <div class="log-item">

                        Evaluating entropy...

                    </div>

                    <div class="log-item">

                        Choosing next guess...

                    </div>

                </div>

            </aside>

        </main>

        <!-- ================= FOOTER ================= -->

        <footer class="footer">

            <div class="stat">

                🏆 Win :
                <strong>100%</strong>

            </div>

            <div class="stat">

                📈 Avg :
                <strong>3.2 guesses</strong>

            </div>

            <div class="stat">

                ⏱ Time :
                <strong>2.4 s</strong>

            </div>

        </footer>

    </div>

    <script src="js.js"></script>

</body>
<?php
require_once __DIR__ . '/../src/Api/WordleClient.php';
?>
</html>