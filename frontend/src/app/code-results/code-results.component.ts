import { Component, OnInit, Input } from '@angular/core';

import { Statistics } from '../statistics.model';

@Component({
  selector: 'app-code-results',
  templateUrl: './code-results.component.html',
  styleUrls: ['./code-results.component.css']
})
export class CodeResultsComponent implements OnInit {

  @Input() stats: Statistics;

  constructor() { }

  ngOnInit() {
  }

}
