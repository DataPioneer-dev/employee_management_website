function convertNumberToArabicWords(number) {
  var arabicWords = ["صفر", "واحد", "اثنان", "ثلاثة", "أربعة", "خمسة", "ستة", "سبعة", "ثمانية", "تسعة"];
  var arabicUnits = ["", "واحد", "اثنان", "ثلاث", "أربع", "خمس", "ست", "سبع", "ثمان", "تسع"];
  var arabicTens = ["", "عشرة", "عشرون", "ثلاثون", "أربعون", "خمسون", "ستون", "سبعون", "ثمانون", "تسعون"];
  var arabicHundreds = ["", "مئة", "مئتان", "ثلاثمئة", "أربعمئة", "خمسمئة", "ستمئة", "سبعمئة", "ثمانمئة", "تسعمئة"];

  if (number === 0) {
    return arabicWords[0];
  }

  var words = "";

  // Convertir les centaines
  if (number >= 100) {
    var hundreds = Math.floor(number / 100);
    words += arabicHundreds[hundreds] + " ";
    number %= 100;
  }

  // Convertir les dizaines et les unités
  if (number >= 20) {
    var tens = Math.floor(number / 10);
    words += arabicTens[tens] + " ";
    number %= 10;
  }

  if (number > 0) {
    words += arabicUnits[number] + " ";
  }

  return words.trim();
}

// Exemple d'utilisation
var number = 123;
var arabicWords = convertNumberToArabicWords(number);
console.log(arabicWords); 



