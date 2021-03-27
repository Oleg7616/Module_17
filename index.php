<?php 
  include 'examples_persons_array.php';

  $fullName = $example_persons_array[random_int(0, count($example_persons_array) - 1)]['fullname'];

  function getPartsFromFullname ($fullName) {
      $arrKeys = ['name', 'surname', 'patronomyc'];
      $fullNameArr = explode (' ', $fullName );
      return array_combine($arrKeys, $fullNameArr);
  }

  function getFullnameFromParts ($surname, $name, $patronomyc) {
      return $surname . ' ' . $name . ' ' . $patronomyc;
  }

  function getShortName ($fullName) {
      $parts = getPartsFromFullname ($fullName);
      return $parts ['name'] . ' ' . mb_substr ($fullName ['surname'], 0, 1) . '.';
  }

  function getGenderFromName ($fullName) {
      $parts = getPartsFromFullname ($fullName);
      $sexAttribute = 0;
           if (mb_substr ($parts ['patronomyc'],-3,3) == 'вна' ||
               mb_substr ($parts ['name'],-1,2) == 'а' ||
               mb_substr ($parts ['surname'],-2,1) == 'ва')
               --$sexAttribute;

           if (mb_substr ($parts ['patronomyc'],-2,1) == 'ич' ||
               mb_substr ($parts ['name'],-1,2) == 'й' || mb_substr ($parts ['name'],-1,2) == 'н' ||
               mb_substr ($parts ['surname'],-1,1) == 'в')
               ++$sexAttribute;

               switch ($sexAttribute <=> 0) {
                   case 1:
                       return 'male';
                       break;

                   case -1:
                       return 'female';
                       break;

                   default:
                       return 'undefinite'; 
                }
    }

    function getGenderDescription ($personsArray) {
        $getMale = array_filter($personsArray, function($person) {
            return getGenderFromName ($person['fullname']) == 'male';
        });

        $getFemale = array_filter($personsArray, function($person) {
            return getGenderFromName ($person['fullname']) == 'female';
        });

        $getUndefined = array_filter($personsArray, function($person) {
            return getGenderFromName($person['fullname']) == 'undefined';
        });

        $male = round(count($getMale)*100/count($personsArray),1);
        $female = round(count($getFemale)*100/count($personsArray),1);
        $undefined = round(count($getUndefined)*100/count($personsArray),1);
    

        echo <<<HEREDOCLETTER
    Гендерный состав аудитории:\n
    ---------------------------\n
    Мужчины - $male%\n
    Женщины - $female%\n
    Не удалось определить - $undefined%\n
    HEREDOCLETTER;
    }

    print_r(getGenderDescription($example_persons_array));
    print_r(getPartsFromFullname ($fullName));
    
    
    

