import { Component, OnInit, Input } from '@angular/core';

import { Statistics } from '../../statistics.model';

@Component({
  selector: 'app-code-comparison-result',
  templateUrl: './code-comparison-result.component.html',
  styleUrls: ['./code-comparison-result.component.css']
})
export class CodeComparisonResultComponent implements OnInit {

  @Input() stats: Statistics;

  constructor() { }

  ngOnInit() {
  }

}
