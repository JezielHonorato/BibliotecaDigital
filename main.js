const Ranges = document.querySelectorAll(".LinhaDupla input");

Ranges.forEach(input =>{
    input.addEventListener("input", ()=>{
        let minVal = parseInt(Ranges[0].value),
        maxVal = parseInt(Ranges[1].value);

        console.log(minVal, maxVal);
    });
});