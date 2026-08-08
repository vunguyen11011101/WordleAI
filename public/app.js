const autoButton = document.querySelector('.primary');
const stepButton = document.querySelector('.actions button:nth-child(2)');
const restartButton = document.querySelector('.actions button:nth-child(3)');

const rows = document.querySelectorAll('.board .row');

autoButton.addEventListener('click', async () => {

    try {

        autoButton.disabled = true;

        const response = await fetch('api.php', {
            method: 'POST'
        });

        const data = await response.json();

        if (!data.success) {
            throw new Error(data.error);
        }

        // Render board
        renderBoard(data.guesses);

        // Update thông tin
        updateGameInfo(data);

    } catch (error) {

        console.error(error);

        alert(error.message);

    } finally {

        autoButton.disabled = false;
    }
});

function renderBoard(guesses) {

    // Xóa board cũ
    clearBoard();

    guesses.forEach((guess, rowIndex) => {

        const row = rows[rowIndex];

        if (!row) {
            return;
        }

        guess.forEach(tile => {

            const position = Number(tile.slot);

            const tileElement = row.children[position];

            if (!tileElement) {
                return;
            }

            tileElement.textContent =
                tile.letter.toUpperCase();

            tileElement.classList.add(
                getTileClass(tile.status)
            );
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


function updateGameInfo(data) {

    const info = document.querySelector('.info');

    const statusText = data.solved
        ? 'Solved'
        : 'Not solved';

    info.innerHTML = `
        <p>
            <strong>Status:</strong>
            ${statusText}
        </p>

        <p>
            <strong>Attempts:</strong>
            ${data.attempts} / 6
        </p>

        <p>
            <strong>Candidates:</strong>
            -
        </p>

        <p>
            <strong>Strategy:</strong>
            Basic Filter
        </p>
    `;
}
