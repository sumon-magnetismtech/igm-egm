 < ? p h p 
 
 n a m e s p a c e   A p p \ E x p o r t s ; 
 
 u s e   A p p \ D e l i v e r y o r d e r ; 
 u s e   I l l u m i n a t e \ C o n t r a c t s \ V i e w \ V i e w ; 
 u s e   M a a t w e b s i t e \ E x c e l \ C o n c e r n s \ F r o m V i e w ; 
 
 c l a s s   D e l i v e r y O r d e r E x p o r t   i m p l e m e n t s   F r o m V i e w 
 { 
         p u b l i c   f u n c t i o n   v i e w ( )   :   V i e w 
         { 
                 r e t u r n   v i e w ( ' e x p o r t s . i n v o i c e s ' ,   [ 
                         ' d e l i v e r y O r d e r s '   = >   D e l i v e r y o r d e r : : a l l ( ) 
                 ] ) ; 
         } 
 }