import { 
  Component, 
  OnInit, 
  Input, 
  EventEmitter,
  Output } from '@angular/core';

import { CodeFile } from '../../code-file.model';

@Component({
  selector: 'app-code-file-tab',
  templateUrl: './code-file-tab.component.html',
  styleUrls: ['./code-file-tab.component.css']
})
export class CodeFileTabComponent implements OnInit {

  @Input() codeFile: CodeFile;
  @Output() onTabSelected: EventEmitter<CodeFile>;

  constructor() { this.onTabSelected = new EventEmitter<CodeFile>(); }

  ngOnInit() {
  }

  tabSelected(): boolean {
    this.onTabSelected.emit(this.codeFile);
    return false;
  }

}
