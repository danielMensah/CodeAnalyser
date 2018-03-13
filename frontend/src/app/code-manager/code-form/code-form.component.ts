import { Component, OnInit, Input, Output, EventEmitter } from '@angular/core';

import codemirror from 'codemirror';

@Component({
  selector: 'app-code-form',
  templateUrl: './code-form.component.html',
  styleUrls: ['./code-form.component.css']
})


export class CodeFormComponent implements OnInit {

  @Input() displayValue: string;
  @Output() onCodeSubmit: EventEmitter<string>;
  

  constructor() { 
    //CodeMirror.fromTextArea(document.getElementById("editor"));
    this.onCodeSubmit = new EventEmitter<string>();
  }

  ngOnInit() {

  }

  submitCode(elem: HTMLInputElement): void {
    this.onCodeSubmit.emit(elem.value);
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
