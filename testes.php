<label for="frequencia_uso">Select Frequency:</label>
<select id="frequencia_uso" name="frequencia_uso">
    <option value="" disabled>Select an option</option>
</select>

<script>
    // Arrays containing the values and labels for the select options
    let frequencia_text = ["1x ao dia/ ou a cada 24h", "2x ao dia/ ou a cada 12h", "3x ao dia/ ou a cada 08h", "4x ao dia/ ou a cada 06h", "6x ao dia/ ou a cada 04h"];
    let frequencia_value = [24, 12, 8, 6, 4];

    let select = document.getElementById("frequencia_uso");

    // Retrieve the value from PHP and convert it to JavaScript
    let frequenciaBanco = <?php echo isset($medicamento['frequencia_uso']) ? $medicamento['frequencia_uso'] : 'null'; ?>;

    // Dynamically add options to the <select> element
    frequencia_text.forEach((text, index) => {
        let option = document.createElement("option");
        option.value = frequencia_value[index];
        option.text = text;

        // If the value matches the one from the database, mark it as selected
        if (frequenciaBanco !== null && frequenciaBanco == frequencia_value[index]) {
            option.selected = true;
        }

        select.add(option);
    });

    // Capture user selection
    select.addEventListener("change", function() {
        let selectedIndex = select.selectedIndex;
        let selectedValue = select.value;
        let selectedText = select.options[selectedIndex].text;
        console.log("Selected Value: " + selectedValue + ", Text: " + selectedText);
    });
</script>
