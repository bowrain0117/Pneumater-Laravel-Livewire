require('./bootstrap');

require('alpinejs');

import { Select, initTE } from "tw-elements";
initTE({ Select });

Window.Select = Select;

