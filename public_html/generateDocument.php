<?php require_once("../includes/braintree_init.php"); ?>

<?php require_once("../includes/head.php"); ?>

<?php 

// require_once 'bootstrap.php';

// Creating the new document...
$phpWord = new \PhpOffice\PhpWord\PhpWord();
$phpWord->setDefaultFontName('calibri');
$phpWord->setDefaultFontSize('11');


/* Note: any element you append to a document must reside inside of a Section. */
// $fontStyle = new \PhpOffice\PhpWord\Style\Font();
// $fontStyle->setName('Calibri');
// $fontStyle->setSize(11);
// $myTextElement = $section->addText('"Believe you can and you\'re halfway there." (Theodor Roosevelt)');


// Adding an empty Section to the document...
$section = $phpWord->addSection();
// Adding Text element to the Section having font styled by default...
$phpWord->addTitleStyle(1, array('bold' => true), array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));
$section->addTitle("CONTRACT DE SPONSORIZARE", 1);

$phpWord->addTitleStyle(2, array('bold' => false), array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));
$section->addTitle("Încheiat azi, ..........................", 2);

$section->addTextBreak(3);

$textrun = $section->addTextRun();
$textrun->addText('Între');
$textrun->addTextBreak();
$textrun->addText('Societatea Comercială', array('bold' => true));
$textrun->addText(" ........................................................................................................, cu sediul în .................................................................................................................., înmatriculată în Registrul Comerţului sub nr. ................................................., cod fiscal nr. .............................................., IBAN: ......................................................, deschis la ..........................................., reprezentată prin dl/dna în calitate de .................., ");
$textrun->addTextBreak();
$textrun->addText('în calitate de ');
$textrun->addText('Sponsor', array('bold' => true));
$textrun->addText(', şi');

$textrun->addTextBreak();
$textrun->addTextBreak();
$textrun->addText('Asociația Recorder Community', array('bold' => true));
$textrun->addText(', cu sediul în Bucureşti, strada Plut. Nedelcu Ion, nr. 1, bloc 1, sc. A, et. 1, ap.7, sector 3; email: office@recorder.ro, având cod fiscal 38496301, cont bancar RO86BACX0000001511885001, deschis la UniCredit Bank România sucursala Magheru, reprezentată legal prin Răzvan Ionescu, Președinte al Consiliului Director,');
$textrun->addTextBreak();
$textrun->addText('în calitate de ');
$textrun->addText('Beneficiar', array('bold' => true));
$textrun->addText(',');

$textrun->addTextBreak();
$textrun->addTextBreak();
$textrun->addText('a intervenit următorul contract:');

$textrun->addTextBreak();
$textrun->addTextBreak();
$textrun->addTextBreak();
$textrun->addTextBreak();

$textrun->addText('OBIECTUL CONTRACTULUI', array('bold' => true));

$textrun->addTextBreak();
$textrun->addTextBreak();
$textrun->addTextBreak();
$textrun->addText('Obiectul contractului constă în ');
$textrun->addText('sponsorizarea proiectelor jurnalistice în interes public, derulate de Beneficiar.', array('bold' => true));

$textrun->addTextBreak();
$textrun->addTextBreak();
$textrun->addTextBreak();

// $textrun->setFontStyle($fontStyle);
$textrun->addText('OBLIGAŢIILE PĂRŢILOR', array('bold' => true));

$textrun->addTextBreak();
$textrun->addTextBreak();

$textrun->addText('Asociația Recorder Community se obligă:');

$section->addListItem("să folosească sponsorizarea exclusiv pentru desfăşurarea activităţii ce formează obiectul prezentului contract, cu scopul de a promova și dezvolta jurnalismul în România, prin susținerea unor proiecte editoriale de mare interes public");

$textrun2 = $section->addTextRun();
$textrun2->addTextBreak();

$textrun2->addText('Sponsorul se obligă:', array('bold' => true));
$textrun2->addTextBreak();
$textrun2->addTextBreak();
$textrun2->addText('Să ofere ');
$textrun2->addText('suma de ', array('bold' => true));
$textrun2->addText('............');
$textrun2->addText('de RON');

$textrun2->addTextBreak();
$textrun2->addTextBreak();
$textrun2->addTextBreak();
$textrun2->addTextBreak();
$textrun2->addTextBreak();


$textrun2->addText('CLAUZE FINALE', array('bold' => true));

$textrun2->addTextBreak();
$textrun2->addTextBreak();

$textrun2->addText('Durata contractului ', array('bold' => true));
$textrun2->addText('este de 12 (douăsprezece) luni, începând de la data semnării prezentului contract.');
$textrun2->addTextBreak();
$textrun2->addText('Părţile implicate vor beneficia de toate facilităţile acordate conform Legii sponsorizării nr. 32/1994.');
$textrun2->addTextBreak();
$textrun2->addTextBreak();
$textrun2->addTextBreak();
$textrun2->addTextBreak();
$textrun2->addText('Asociația Recorder Community respectă prevederile Regulamentului General pentru Protecția Datelor (GDPR). ');
$textrun2->addTextBreak();
$textrun2->addTextBreak();

$textrun2->addText('Datele personale ale sponsorilor (nume, prenume,  număr de telefon, adresă de e-mail) sunt informații confidențiale, ');
$textrun2->addText('pe care Asociația Recorder Community ', array('bold' => true));
$textrun2->addText(' le colectează și utilizează cu maximă responsabilitate, prin crearea politicilor de protecție a datelor și prin implementarea acestor politici la nivelul întregii organizații.  ');
$textrun2->addTextBreak();
$textrun2->addTextBreak();

$textrun2->addText('Sponsorii pot solicita oricând accesul la datele personale pe care Asociația Recorder Community le deține despre ei, printr-un e-mail trimis către office@recorder.ro, iar într-un interval de 3 zile lucrătoare organizația îi va pune la dispoziție informațiile solicitate.');
$textrun2->addTextBreak();
$textrun2->addTextBreak();

$textrun2->addText('Cu toate că Regulamentul General pentru Protecția Datelor se aplică în toate statele Uniunii Europene, GDPR nu poate anula prevederile legale naționale care stabilesc păstrarea datelor personale în documentele financiare. Spre exemplu, conform legii, datele personale (nume, prenume, CNP, adresă, date act de identitate) din documentele financiare (facturi, extrase de cont, chitanțe, registre) vor fi păstrate până la 10 ani de la data generării lor. În acest caz informațiile nu pot fi șterse, chiar dacă există o solicitare în acest sens din partea donatorului. ');
$textrun2->addTextBreak();
$textrun2->addTextBreak();

$textrun2->addText('În cazul în care ștergerea informațiilor nu contravine legii, datele personale ale sponsorului vor fi eliminate din baza de date în cel mult 3 zile lucrătoare de la data solicitării. ');
$textrun2->addTextBreak();
$textrun2->addTextBreak();

$textrun2->addText('Prezentul contract a fost întocmit în două (2) exemplare, unul pentru fiecare parte.');
$textrun2->addTextBreak();
$textrun2->addTextBreak();
$textrun2->addTextBreak();
$textrun2->addTextBreak();
$textrun2->addTextBreak();
$textrun2->addTextBreak();


$textrun2->addText('SPONSOR', array('bold' => true));
$textrun2->addText('								');
$textrun2->addText('BENEFICIAR', array('bold' => true));
$textrun2->addTextBreak();
$textrun2->addTextBreak();
$textrun2->addTextBreak();
$textrun2->addText('...........................                          Asociația Recorder Community');
$textrun2->addTextBreak();
$textrun2->addText('...........................                          Răzvan Ionescu');
$textrun2->addTextBreak();
$textrun2->addText('...........................                          Președintele Consiliului Director');

/*
 * Note: it's possible to customize font style of the Text element you add in three ways:
 * - inline;
 * - using named font style (new font style object will be implicitly created);
 * - using explicitly created font style object.
 */



// Saving the document as OOXML file...
$objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
$objWriter->save('recorder-sponsorizare.docx');