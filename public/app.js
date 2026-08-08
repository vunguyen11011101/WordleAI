// ============================================================
// DOM ELEMENTS
// ============================================================

const autoButton = document.querySelector('.primary');

const stepButton = document.querySelector(
    '.actions button:nth-child(2)'
);

const restartButton = document.querySelector(
    '.actions button:nth-child(3)'
);

const rows = document.querySelectorAll('.board .row');


// Test mode
const targetInput = document.querySelector('#targetWord');
const testButton = document.querySelector('#testButton');


// ============================================================
// EVENT LISTENERS
// ============================================================

// -------------------------
// Auto - Daily
// -------------------------

autoButton.addEventListener('click', () => {

    runGame({
        mode: 'daily'
    });

});


// -------------------------
// Test Mode
// -------------------------

if (testButton) {

    testButton.addEventListener('click', () => {

        const target = targetInput.value
            .trim()
            .toLowerCase();

        if (target.length !== 5) {

            alert(
                'Vui lòng nhập một từ có đúng 5 chữ cái.'
            );

            return;
        }

        runGame({
            mode: 'test',
            target: target
        });

    });

}


// -------------------------
// Step
// -------------------------

stepButton.addEventListener('click', () => {

    console.log('Step mode chưa được triển khai.');

});


// -------------------------
// Restart
// -------------------------

restartButton.addEventListener('click', () => {

    clearBoard();

    resetGameInfo();

});


// ============================================================
// GAME
// ============================================================

async function runGame(gameOptions) {

    try {

        setButtonsDisabled(true);

        const response = await fetch('api.php', {

            method: 'POST',

            headers: {
                'Content-Type': 'application/json'
            },

            body: JSON.stringify(gameOptions)

        });


        // Kiểm tra HTTP response

        if (!response.ok) {

            throw new Error(
                `HTTP Error: ${response.status}`
            );

        }


        const data = await response.json();


        // Kiểm tra API response

        if (!data.success) {

            throw new Error(
                data.error || 'Unknown API error.'
            );

        }


        // Render kết quả

        renderBoard(data.guesses);

        updateGameInfo(data);


    } catch (error) {

        console.error(
            'Game error:',
            error
        );

        alert(error.message);


    } finally {

        setButtonsDisabled(false);

    }

}


// ============================================================
// BOARD
// ============================================================

function renderBoard(guesses) {

    clearBoard();


    guesses.forEach((guess, rowIndex) => {

        const row = rows[rowIndex];

        if (!row) {
            return;
        }


        guess.forEach(tile => {

            const position = Number(tile.slot);

            const tileElement =
                row.children[position];


            if (!tileElement) {
                return;
            }


            // Letter

            tileElement.textContent =
                tile.letter.toUpperCase();


            // Status

            const tileClass =
                getTileClass(tile.status);


            if (tileClass) {

                tileElement.classList.add(
                    tileClass
                );

            }

        });

    });

}


function getTileClass(status) {

    switch (status) {

        case 'correct':
            return 'green';

        case 'present':
            return 'yellow';

        case 'absent':
            return 'gray';

        default:
            return '';

    }

}


function clearBoard() {

    rows.forEach(row => {

        Array.from(row.children).forEach(tile => {

            tile.textContent = '';

            tile.classList.remove(
                'green',
                'yellow',
                'gray'
            );

        });

    });

}


// ============================================================
// GAME INFORMATION
// ============================================================

function updateGameInfo(data) {

    const info =
        document.querySelector('.info');


    const statusText = data.solved
        ? 'Solved'
        : 'Not solved';


    const modeText = data.mode === 'test'
        ? 'Test'
        : 'Daily';


    info.innerHTML = `

        <p>
            <strong>Trạng thái:</strong>
            ${statusText}
        </p>

        <p>
            <strong>Chế độ:</strong>
            ${modeText}
        </p>

        <p>
            <strong>Lượt:</strong>
            ${data.attempts} / 6
        </p>

        <p>
            <strong>Candidates:</strong>
            -
        </p>

        <p>
            <strong>Chiến lược:</strong>
            Basic Filter
        </p>

    `;

}


function resetGameInfo() {

    const info =
        document.querySelector('.info');


    info.innerHTML = `

        <p>
            <strong>Trạng thái:</strong>
            Ready
        </p>

        <p>
            <strong>Chế độ:</strong>
            -
        </p>

        <p>
            <strong>Lượt:</strong>
            0 / 6
        </p>

        <p>
            <strong>Candidates:</strong>
            -
        </p>

        <p>
            <strong>Chiến lược:</strong>
            Basic Filter
        </p>

    `;

}


// ============================================================
// BUTTON STATE
// ============================================================

function setButtonsDisabled(disabled) {

    autoButton.disabled = disabled;

    stepButton.disabled = disabled;

    if (testButton) {
        testButton.disabled = disabled;
    }

}