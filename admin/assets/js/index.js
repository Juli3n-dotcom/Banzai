//index date
const date = new Date();
let day = date.getDay();

function NomDuJour (QuelleDate)
  {
  switch (QuelleDate.getDay())
    {
    case 1 : return "Lundi"
             break
    case 2 : return "Mardi"
             break
    case 3 : return "Mercredi"
             break
    case 4 : return "Jeudi"
             break
    case 5 : return "Vendredi"
             break
    case 6 : return "Samedi"
             break
    case 7 : return "Dimanche"
             break
    } // Fin du switch
  } // Fin de la fonction NomDuJour

  function NomDuMois (QuelleDate)
  {
  switch (QuelleDate.getMonth())
    {
    case 1 : return "Janvier"
             break
    case 2 : return "Février"
             break
    case 3 : return "Mars"
             break
    case 4 : return "Avril"
             break
    case 5 : return "Mai"
             break
    case 6 : return "Juin"
            break
    case 7 : return "Juillet"
            break
    case 8 : return "Aout"
            break
    case 9 : return "Septembre"
            break
    case 10 : return "Octobre"
            break
    case 11 : return "Novembre"
            break
    case 12 : return "Décembre"
            break
    } // Fin du switch
  } // Fin de la fonction NomDuJour

document.getElementById('date').innerHTML = NomDuJour(date) + ' ' + day + ' ' + NomDuMois(date);