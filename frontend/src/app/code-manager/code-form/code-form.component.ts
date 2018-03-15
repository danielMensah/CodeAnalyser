import { Component, OnInit, Input, Output, EventEmitter } from '@angular/core';``

@Component({
  selector: 'app-code-form',
  templateUrl: './code-form.component.html',
  styleUrls: ['./code-form.component.css']
})


export class CodeFormComponent implements OnInit {

  @Input() disableButtons: boolean;
  @Input() displayValue: string;
  @Output() onCodeSubmit: EventEmitter<{}>;
  @Output() onCompareClicked: EventEmitter<boolean>;
  

  constructor() { 
    this.onCodeSubmit = new EventEmitter<{}>();
    this.onCompareClicked = new EventEmitter<boolean>();
  }

  ngOnInit() {

  }

  submitCode(elem: HTMLInputElement, dropdown: HTMLInputElement): void {
    var rating = dropdown.value;
    var code = elem.value;
    this.onCodeSubmit.emit({code, rating});
  }

  compare(): boolean {
    this.onCompareClicked.emit(true);
    return false;
  }

  readFile(input: HTMLInputElement): boolean {    
    var fileReader = new FileReader();
    fileReader.onload = (e)=> {
      this.displayValue = fileReader.result;
    }

    fileReader.readAsText(input.files[0]);

    input.value="";
    return false;
  }

}
