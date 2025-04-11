
/**
 * Capability check box name.
 */
const checkBoxName = 'role_caps';

/**
 * Add capability to the list.
 * @param {string} inputSelector Input selector.
 * @param {string} addBtnSelector Add button selector.
 * @param {string} listSelector List selector.
 * @returns void
 */
export function addNewCapability(inputSelector, addBtnSelector, listSelector) {

    const input = document.querySelector(inputSelector)
    const addBtn = document.querySelector(addBtnSelector);
    const capabilitiesList = document.querySelector(listSelector);

    addBtn.addEventListener('click', function() {
        input.reportValidity();
        if (!input.validity.valid) {
            return;
        }
        capabilitiesList.appendChild(createCapabilityItem(input.value.trim(), checkBoxName));
        input.value = '';
    });
}


/**
 * Create a new capability item.
 * @param {string} capability 
 * @returns HtmlElement
 */
function createCapabilityItem(capability, inputName) {
    const name = inputName + '[ ' + capability + ' ]';
    const capabilityItem = document.createElement('li');
    capabilityItem.innerHTML =
        `<input type="hidden" name="${name}" value="0"> 
        <label>
            <input type="checkbox" name="${name}" value="1">
            ${capability}
        </label>`;

    return capabilityItem;
}

export function addCapabilityFromList(checkboxSelector, submitButtonSelector, listSelector) { 
    /** @type {NodeListOf<HTMLInputElement>} */
    const checkBoxes = document.querySelectorAll(checkboxSelector);

    /** @type {HTMLButtonElement} */
    const submitButton = document.querySelector(submitButtonSelector);

    /** @type {HTMLUListElement} */
    const list = document.querySelector(listSelector);

    if (!checkBoxes || !submitButton || !list) {
        console.warn('Aikon Role Manager: One or more elements not found in addCapabilityFromList()');
        return;
    }

    submitButton.disabled = true;

    const checkHasChecked  = () => {
        // Loop through all checkboxes and check if any is checked
        const checkedCount = [...checkBoxes].filter(input => input.checked).length;
        console.log(checkedCount);
        return checkedCount > 0;
    }

    checkBoxes.forEach((box)=>{
        box.addEventListener('change', () => {
            submitButton.disabled = !checkHasChecked();
        });
    });

    submitButton.addEventListener('click', (e) => {
        const checked = [...checkBoxes].filter(input => input.checked);
        checked.forEach((checkbox) => {
            const capname = checkbox.parentElement.textContent.trim()
            list.appendChild(createCapabilityItem(capname, checkbox.name));
            checkbox.checked = false
            checkbox.disabled = true;
        });
        submitButton.disabled = true;
    });
}