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
                        <div class="tile"></div>
                        <div class="tile"></div>
                        <div class="tile"></div>
                        <div class="tile"></div>
                        <div class="tile"></div>
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
                        <strong>Status:</strong>
                        <span id="statusText">Not solved</span>
                    </p>

                    <p>
                        <strong>Attempts:</strong>
                        <span id="attemptText">0 / 6</span>
                    </p>

                    <p>
                        <strong>Candidates:</strong>
                        <span id="candidateText">-</span>
                    </p>

                    <p>
                        <strong>Strategy:</strong>
                        <span id="strategyText">Entropy</span>
                    </p>

                </div>

                <div class="actions">

                    <button id="autoSolveBtn" class="primary">
                        ▶ Auto Solve
                    </button>

                    <button id="stepBtn">
                        ⏭ Step by Step
                    </button>

                    <button id="resetBtn">
                        ↻ Reset
                    </button>

                </div>

                <hr>

                
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

    <script src="app.js"></script>  

</body>
<?php
require_once __DIR__ . '/../src/API/WordleClient.php';
?>
</html>