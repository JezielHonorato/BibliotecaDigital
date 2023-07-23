let a = 1
let b = 1
console.log("2")

function RangeData(value){
    if(value == 0){
        document.getElementById('ano_value').innerHTML = "A. C."
    }
    else{
        document.getElementById('ano_value').innerHTML = value;
        if(b == 1){
            AntesDepois()
            b++
        }
    }
}
function AntesDepois(){
    b++
    if(a == 0){
        document.getElementById('radio_label').innerHTML = "Escolha o periodo:"
        a++
    }
    else if(a == 1){
        document.getElementById('radio_label').innerHTML = "Apenas livros do ano:"
        a++
    }
    else if(a == 2){
        document.getElementById('radio_label').innerHTML = "Apenas livros depois do ano:"
        a++
    }
    else if(a == 3){
        document.getElementById('radio_label').innerHTML = "Apenas livros antes do ano:"
        a = 0
    }

}




const rangeInput = document.querySelectorAll(".multi-range input"),
progress = document.querySelector(".Linha .Progresso");

let priceGap = 1000
/*
priceInput.forEach(input =>{
    input.addEventListener("input", ()=>{
        let minVal = parseInt(priceInput[0].value),
        maxVal = parseInt(priceInput[1].value);

        if((maxVal - minVal >= priceGap) && maxVal <= 10000){
            if(e.target.className === "input-min"){
                rangeInput[0].value = minVal;
                progress.style.left = minVal / rangeInput[0].max * 100 + "%";
            }
            else{
                rangeInput[1].value = maxVal;
                progress.style.rigth = 100 - (maxVal / rangeInput[1].max) * 100 + "%";
            }
        }
    });
});
*/

rangeInput.forEach(input =>{
    input.addEventListener("input", ()=>{
        let minVal = parseInt(rangeInput[0].value),
        maxVal = parseInt(rangeInput[1].value);

        console.log(minVal, maxVal);

    });
});

console.log("2")

/*4


        if(maxVal - minVal < priceGap){
            if(e.target.className === "range-min"){
                rangeInput[0].value = maxVal - priceGap;
            }
            else{
                rangeInput[1].value = maxVal + priceGap;
            }
        }
        else{
            priceInput[0].value = minVal;
            priceInput[1].value = maxVal;
            progress.style.left = minVal / rangeInput[0].max * 100 + "%";
            progress.style.rigth = 100 - (maxVal / rangeInput[1].max) * 100 + "%";
        }
*/

/*
var lowerSlider = document.querySelector('#lower'),
upperSlider = document.querySelector('#upper'),
lowerVal = parseInt(lowerSlider.value);
upperVal = parseInt(upperSlider.value);

upperSlider.oninput = function() {
lowerVal = parseInt(lowerSlider.value);
upperVal = parseInt(upperSlider.value);

if (upperVal < lowerVal + 4) {
    lowerSlider.value = upperVal - 4;
    
    if (lowerVal == lowerSlider.min) {
        upperSlider.value = 4;
    }
}
};


lowerSlider.oninput = function() {
lowerVal = parseInt(lowerSlider.value);
upperVal = parseInt(upperSlider.value);

if (lowerVal > upperVal - 4) {
    upperSlider.value = lowerVal + 4;
    
    if (upperVal == upperSlider.max) {
        lowerSlider.value = parseInt(upperSlider.max) - 4;
    }

}
};
*/