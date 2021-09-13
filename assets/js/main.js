let current_cell;

let strValue = document.querySelectorAll('.str__value a');

for (let i = 0; i < strValue.length; i++) {
    strValue[i].addEventListener('click', function() {
        current_cell = this;
        let table = this.dataset.table;
        let column = this.dataset.column;
        document.querySelector('[name="table"]').value = table;
        document.querySelector('[name="column"]').value = column;
    });
}

let formChange = document.querySelector('#change-value form');

formChange.addEventListener('submit', function (e) {
    e.preventDefault();
    fetch('assets/action.php', {
        method: 'POST',
        body: new FormData(formChange),
    }).then( (response) => {
        if (response.status !== 200) {
            return Promise.reject();
        }
        return response.text();
    }).then( 
        answer => {
            formChange.reset();
            current_cell.innerHTML = answer;
            myModal.close();
        }
    ).catch(
        () => console.log('error')
    );
});

const myModal = new HystModal({
    linkAttributeName: "data-hystmodal",
});